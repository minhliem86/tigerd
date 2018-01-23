<?php

namespace App\Modules\Client\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\AttributeValueRepository;
use Validator;
use Cart;
use Auth;
use Carbon\Carbon;
use App\Repositories\PromotionRepository;
use App\Repositories\PaymentMethodRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ShipAddressRepository;

class ProductController extends Controller
{
    protected $cate;
    protected $product;
    protected $value;

    protected $merchant;
    protected $access;
    protected $secure;

    public function __construct(CategoryRepository $cate, ProductRepository $product, AttributeValueRepository $value)
    {
        $this->cate = $cate;
        $this->product = $product;
        $this->value = $value;

        $this->merchant = env('OP_MERCHANT');
        $this->access = env('OP_ACCESS');
        $this->secure = env('OP_SECURE');

        $this->auth = Auth::guard('customer');
        $this->middleware('client_checklogin',['only'=>['doPayment', 'responseFormOnePay']]);
    }

    private function setupOnePay(){
        $onepay = new \ClassOnepay();
        $onepay->setupMerchant($this->merchant, $this->access, $this->secure);
        return $onepay;
    }

    private function _rulesPayment(){
        return [
          'customer_name' => 'required',
            'vpc_Customer_Phone' => 'required',
            'vpc_Customer_Email' => 'required|email',
            'payment_method' => 'required'
        ];
    }

    private function _messagePayment(){
        return [
            'customer_name.required' => 'Vui lòng nhập Tên',
            'vpc_Customer_Phone.required' => 'Vui lòng nhập Số điện thoại',
            'vpc_Customer_Email.required' => 'Vui lòng nhập Email',
            'vpc_Customer_Email.email' => 'Vui lòng nhập định dạng Email',
            'payment_method.required' => 'Vui lòng chọn Phương thức thanh toán',
        ];
    }

    private function _rulesAddToCart()
    {
        return [
          'price' => 'required|min:1',
            'quantity' => 'required|min:1|max:10',
            'att_value.*'=> 'required'
        ];
    }

    private function _messageAddToCart()
    {
        return [
          'price.required' => 'Lỗi trong quá trình xử lý Giá.',
          'price.min' => 'Lỗi trong quá trình xử lý Giá.',
          'quantity.required' => 'Lỗi trong quá trình xử lý Số lượng.',
          'quantity.min' => 'Lỗi trong quá trình xử lý Số lượng tối thiểu.',
          'quantity.max' => 'Lỗi trong quá trình xử lý Số lượng tối đa.',
          'att_value.*.required' => 'Vui lòng chọn 1 thuộc tính sản phẩm.'
        ];
    }

    public function getCategory($slug)
    {
        $all_cate = $this->cate->all(['id', 'name', 'slug']);
        $hotProduct = $this->product->hotProduct(['id', 'slug', 'name' , 'img_url']);
        $cate = $this->cate->findByField('slug', $slug, ['id', 'name', 'slug'], ['products'])->first();
        if(count($cate)){
            return view('Client::pages.product.list_product', compact('cate', 'all_cate', 'hotProduct'));
        }
        return abort(404);
    }

    public function getProduct($slug)
    {
        $product = $this->product->getProductBySlug($slug,['id','name', 'slug', 'description', 'content', 'sku_product', 'price', 'discount', 'img_url','category_id'], ['categories','photos', 'values', 'attributes']);

        if(count($product)){
            $relate_product = $this->product->relateProduct([$product->id], ['id', 'slug', 'name', 'price', 'discount', 'img_url']);
            $arr_value_product = [];
            if(!$product->values->isEmpty()){
                foreach($product->values as $item){
                    array_push($arr_value_product, $item->id);
                }
            }
            return view('Client::pages.product.detail', compact('product', 'relate_product', 'arr_value_product'));
        }
        return abort(404);
    }

    public function addToCart(Request $request)
    {
        $valid = Validator::make($request->all(),$this->_rulesAddToCart(), $this->_messageAddToCart());
        if($valid->fails()){
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }
        $product = $this->product->find($request->input('product_id'),['id','price','discount','name','slug' ,'img_url'],['attributes', 'values']);

        if(count($product)){
            $data_price_check = [
                $product->discount ? $product->discount :  $product->price,
            ];
            $array_value = [];
            $array_attribute = [
                'img_url' => $product->img_url
            ];

            /*CHECK PRODUCT PRICE DO NOT MANUAL*/
            if(!$product->values->isEmpty() && $request->has('att_value')){
                foreach($product->values as $item_value){
                    if($item_value->value_price){
                        array_push($data_price_check, $product->discount ? $product->discount :  $product->price + $item_value->value_price);
                    }
                    array_push($array_value, $item_value->id);
                }
                if(!in_array($request->input('price'), $data_price_check)){
                    $errors = new \Illuminate\Support\MessageBag;
                    $errors->add('error_system','Xảy ra lỗi trong quá trình xử lý: Giá sản phẩm không chính xác.');
                    return redirect()->back()->withInput()->withErrors($errors);
                }
                /*CHECK VALUE BELONG PRODUCT*/
                foreach($request->input('att_value') as $item_value_from_web){
                    if(!in_array($item_value_from_web, $array_value)){
                        $errors = new \Illuminate\Support\MessageBag;
                        $errors->add('error_system','Xảy ra lỗi trong quá trình xử lý: Thuộc tính không thuộc sản phẩm này.');
                        return redirect()->back()->withInput()->withErrors($errors);
                    }
                }

                /*WHEN EVERYTHING IS OK*/
                /*GET DATA-ATT*/
                foreach($product->attributes as $item_att){
                    $value_name = $this->value->find($request->input('att_value')[$item_att->slug])->value;
                    $array_attribute[$item_att->name] = $value_name;
                }
            }
            $price = $request->input('price');

            if(count($array_attribute)){
                $data = [
                    'id' => $product->slug.'_'.$product->id.'_'.$price,
                    'name' => $product->name,
                    'price' => $price,
                    'quantity' => $request->input('quantity'),
                    'attributes' => $array_attribute,
                ];
            }else{
                $data = [
                    'id' => $product->slug.'_'.$product->id.'_'.$price,
                    'name' => $product->name,
                    'price' => $price,
                    'quantity' => $request->input('quantity'),
                ];
            }
            Cart::add($data);

            return redirect()->back()->with(['success'=>'Sản Phẩm đã được thêm vào giỏ hàng', 'data' => $product, 'price' => $price]);
        }else{
            return redirect()->back()->withInput()->with('errors','Xảy ra lỗi trong quá trình xử lý: Sản Phẩm không tồn tại.');
        }
    }

    public function getCart()
    {
        if(Cart::isEmpty()){
            return redirect()->route('client.home')->with('error','Giỏ hàng của bạn đang rỗng. Vui lòng chọn sản phẩm.');
        }
        $cart = $cart = Cart::getContent();
        return view('Client::pages.product.cart', compact('cart'));
    }

    public function clearCart()
    {
        Cart::clear();
        Cart::clearCartConditions();
        return redirect()->route('client.home')->with('error','Giỏ hàng của bạn đã được xóa.');;
    }

    public function getPayment(Request $request, PaymentMethodRepository $paymentMethod)
    {
        if(Cart::isEmpty()){
            return redirect()->route('client.home')->with('error','Giỏ hàng của bạn đang rỗng. Vui lòng chọn sản phẩm.');
        }
        $cart = Cart::getContent();
        $pm = $paymentMethod->all(['id', 'name','description']);
        return view('Client::pages.product.payment', compact('cart', 'pm'));
    }

    public function applyPromotion(Request $request, PromotionRepository $promotion)
    {
        if(!$request->ajax()){
            abort(404);
        }else{
            $promotion_valid = Cart::getConditions();
            if($promotion_valid->isEmpty()){
                $promote_code = $request->input('pr_code');
                $pr = $promotion->query()->where('sku_promotion',$promote_code)->where('status',1)->select('name','sku_promotion', 'num_use','target','value', 'value_type')->first();
                if(count($pr)){
                    if(Cart::getCondition($pr->name)){
                        return response()->json(['error'=>true, 'data'=> null, 'message' => 'Mã Khuyến Mãi chỉ được áp dụng 1 lần cho 1 đơn hàng.'], 200);
                    }else{
                        $cond = new \Darryldecode\Cart\CartCondition(
                            [
                                'name' => $pr->sku_promotion,
                                'type' => 'discount',
                                'target' => $pr->target,
                                'value' => $pr->value_type === '%' ? $pr->value.$pr->value_type : $pr->value,
                            ]
                        );
                        Cart::condition($cond);
                        $condition = Cart::getCondition($pr->name);

                        $subTotal = Cart::getSubTotal();
                        $subTotalAfterCondition = $condition->getCalculatedValue($subTotal);

                        $total = Cart::getTotal();
                        return response()->json(['error' => false, 'data' => json_encode(['total' => $total]), 'message' => 'Mã khuyến mãi đã được áp dụng'], 200);
                    }
                }else{
                    return response()->json(['error'=>true, 'data'=> null, 'message' => 'Mã khuyến mãi đã hết hạn hoặc không tồn tại'], 200);
                }
            }else{
                return response()->json(['error'=>true, 'data'=> null, 'message' => 'Mỗi Đơn Hàng chỉ sử dụng 1 mã  khuyến mãi'], 200);
            }
        }
    }

    public function doPayment(Request $request, OrderRepository $order, PromotionRepository $promotion, ShipAddressRepository $ship)
    {
        if(!$this->auth->check()){
            return redirect()->route('client.auth.login')->with('error','Vui lòng đăng nhập.');
        }
        $valid = Validator::make($request->all(), $this->_rulesPayment(), $this->_messagePayment());
        if($valid->fails()){
            return redirect()->back()->withInput()->withErrors($valid, 'error_payment');
        }
        $payment_method = $request->input('payment_method');
        switch ($payment_method){
            case '1' :
                if($request->has('promotion_name')){
                    $promotion_id = $promotion->query(['id', 'name','status'])->where('status','1')->where('name', $request->input('promotion'));
                }else{
                    $promotion_id = '';
                }
                $data = [
                    'order_date' => Carbon::now(),
                    'total' => Cart::getTotal(),
                    'customer_id' => $this->auth->user()->id,
                    'promotion_id' => $promotion_id,
                    'paymentmethod_id' => 1,
                    'shipstatus_id' => 1,
                    'paymentstatus_id' =>1,
                ];
                $current_order = $order->create($data);

                $data_ship = [
                    'fullname' => $request->customer_name,
                    'phone' => $request->input('vpc_Customer_Phone'),
                    'email' => $request->input('vpc_Customer_Email'),
                    'address' => $request->input('vpc_SHIP_Street01'),
                    'note' => $request->input('customer_note'),
                    'order_id' => $current_order->id,
                ];
                $ship->create($data_ship);

                return redirect()
                break;

            case '2' :
                $order_id = \LP_lib::unicodenospace($request->input('customer_name')).'_'.time();
                $customer_id = $this->auth->user()->firstname . '_'. $this->auth->user()->id ;
                $onepay = $this->setupOnePay();
                $refer = $onepay->build_link_global($request->all(),$order_id, Cart::getTotal(), $request->input('customer_name').' PAY ONLINE', route('client.responsePayment'),  $customer_id);
                return redirect($refer);
                break;
        }


    }

    public function responseFormOnePay(Request $request)
    {
        $onepay = $this->setupOnePay();

        $hashValidated = $onepay->check_response($request->all());

        if($hashValidated === 'CORRECT' && $request->vpc_TxnResponseCode == "0"){
            //thanh cong
            return "thanh cong";
        }elseif($hashValidated=="INVALID HASH" && $request->vpc_TxnResponseCode == "0"){
            // pending
            return "Pending";
        }else{
            //thatbai
            $error_message = $onepay->getResponseDescription($request->vpc_TxnResponseCode);
            return $error_message;
        }
    }



    /*AJAX*/
    /*CHANGE ATTRIBUTE VALUE*/
    public function ajaxChangeAttributeValue(Request $request)
    {
        if(!$request->ajax()){
            return abort(404);
        }else{
            $product_id = $request->input('product_id');
            $value_id = $request->input('value_id');
            $product = $this->product->find($product_id);
            if($value_id){
                if($this->value->find($value_id)->value_price){
                    $price = $product->discount ? $product->discount : $product->price + $this->value->find($value_id)->value_price;
                    return response()->json(['price_format' => number_format($price),'price'=>$price, 'data' => 'Update Giá'], 200);
                }else{
                    $price = $product->discount ? $product->discount : $product->price;
                    return response()->json(['price_format' => number_format($price),'price'=>$price, 'data' => 'Không Update Giá'], 200);
                }
            }else{
                $product = $this->product->find($product_id);
                $price = $product->discount ? $product->discount : $product->price;

                return response()->json(['price_format' => number_format($price),'price'=>$price, 'data' => 'Update Giá'], 200);
            }

        }
    }

    public function updateQuantityAjax(Request $request)
    {
        if(!$request->ajax()){
            abort(404);
        }else{
            $id = $request->input('id');
            $quantity = $request->input('quantity');
            if($quantity <= 0){
                return response()->json(['error' => true, 'data' => 'Số lượng phải lớn hơn 0.']);
            }else {
                Cart::update($id,['quantity'=>['relative'=>false, 'value' => $quantity]]);
                $subTotal = Cart::getSubTotal();
                return response()->json(['error' => false, 'data'=>number_format($subTotal)]);
            }
        }
    }

    public function removeItemCart(Request $request)
    {
        if(!$request->ajax()){
            abort(404);
        }else {
            Cart::remove($request->input('id'));
            $subTotal = Cart::getSubTotal();
            return response()->json(['error' => false, 'data'=>number_format($subTotal)]);
        }
    }

    public function addToCartAjax(Request $request)
    {
        if(!$request->ajax()){
            abort(404);
        }else{
            $id = $request->input('id');
            $product = $this->product->find($id,['id', 'slug', 'name', 'price', 'img_url']);
            $array_attribute = [
                'img_url' => $product->img_url,
            ];
            $itemCart = Cart::add([
                'id'=>$product->slug.'_'.$product->id.'_'.$product->price,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'attributes' => [
                    $array_attribute
                ]
            ]);
            $quantityCart = Cart::getTotalQuantity();
            return response()->json(['error' => false, 'data'=> $quantityCart]);
        }
    }
}
