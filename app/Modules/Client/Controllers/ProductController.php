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
            'vpc_SHIP_Street01' => 'required',
            'payment_method' => 'required'
        ];
    }

    private function _messagePayment(){
        return [
            'customer_name.required' => 'Vui lòng nhập Tên',
            'vpc_Customer_Phone.required' => 'Vui lòng nhập Số điện thoại',
            'vpc_Customer_Email.required' => 'Vui lòng nhập Email',
            'vpc_Customer_Email.email' => 'Vui lòng nhập định dạng Email',
            'vpc_SHIP_Street01.required' => 'Vui lòng nhập địa chỉ giao hàng',
            'payment_method.required' => 'Vui lòng chọn Phương thức thanh toán',
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
        $product = $this->product->getProductBySlug($slug,['id','name', 'slug', 'description', 'content', 'sku_product', 'price', 'discount', 'img_url','category_id','type'], ['categories','photos', 'values', 'attributes','product_links']);
        if(count($product)){
            $array_option_att = [];
            $option = "";
            $relate_product = $this->product->relateProduct([$product->id], ['id', 'img_url', 'name','slug', 'price', 'discount','category_id', 'default'],['attributes', 'product_links']);

            if($product->type == 'configuable'){
                $array_product_id = [];
                if(!$product->product_links->isEmpty()){
                    foreach($product->product_links as $link){
                        array_push($array_product_id, $link->link_to_product_id);
                    }
                }
                $collect_product_child = $this->product->findWhereIn('id', $array_product_id);

                foreach($collect_product_child as $item_child){
                    foreach($item_child->values as $item_value){
                        if($item_value == $item_child->values->last()){
                            $option .= $item_value->attributes->name .': '.$item_value->value;
                        }else {
                            $option .= $item_value->attributes->name . ': ' . $item_value["value"] . ', ';
                        }
                    }
                    $rs_array = "<option value='".$item_child->id."'>".$option."</option>";
                    array_push($array_option_att,$rs_array);
                    $option = "";
                }
                foreach($collect_product_child as $item_default){
                    if($item_default->default){
                        $product = $item_default;
                        break;
                    }
                }

            }

            return view('Client::pages.product.detail', compact('product', 'relate_product', 'array_option_att'));
        }
        return abort(404);
    }

    public function addToCart(Request $request)
    {
        $valid = Validator::make($request->all(), ['att_value.*' => 'required', 'quantity' => 'required|min:1'] , ['att_value.*.required' => 'Vui lòng chọn 1 sản phẩm.', 'quantity.required' => 'Vui lòng chọn số lượng sản phẩn cần mua.', 'quantity.min' => 'Số lượng tối thiểu là 1.']);
        if($valid->fails()){
            return redirect()->back()->withErrors($valid);
        }
        $id = $request->input('product_id');
        $product = $this->product->find($id, ['id', 'name','price', 'discount', 'img_url'], ['values']);
        if(count($product)){
            $att = [
                'img_url' => $product->img_url,
            ];
            if(!$product->values->isEmpty()){
                foreach($product->values as $item_value){
                    $att[$item_value->attributes->name] = $item_value->value;
                }
            }
            $data = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->discount ? $product->discount : $product->price,
                'quantity' => $request->quantity,
                'attributes' => $att,
            ];

            Cart::add($data);
            $price = $product->discount ? $product->discount : $product->price * $request->quantity;
            return redirect()->back()->with(['success'=>'Sản Phẩm đã được thêm vào giỏ hàng', 'data' => $product, 'attribute' => $att ,'price' =>$price]);
        }else{
            return redirect()->back()->withInput()->with('errors','Sản Phẩm không tồn tại.');
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

                        $total = number_format(Cart::getTotal());
                        $view = view('Client::extensions.promotion_payment')->render();
                        return response()->json(['error' => false, 'total' => $total, 'view'=>$view , 'message' => 'Mã khuyến mãi đã được áp dụng'], 200);
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
                    $pr = $promotion->query(['id', 'name','status','sku_promotion'])->where('status','1')->where('sku_promotion', $request->input('promotion_name'))->first();
                    $promotion_id = $pr->id;
                }else{
                    $promotion_id = '';
                }
                /*LUU GIO HANG*/
                $data = [
                    'order_date' => Carbon::now(),
                    'shipping_cost' => 0,
                    'total' => Cart::getTotal(),
                    'customer_id' => $this->auth->user()->id,
                    'promotion_id' => $promotion_id,
                    'paymentmethod_id' => 1,
                    'shipstatus_id' => 1,
                    'paymentstatus_id' =>1,
                ];
                $current_order = $order->create($data);

                /*LUU SHIP ADDRESS*/
                $data_ship = [
                    'fullname' => $request->customer_name,
                    'phone' => $request->input('vpc_Customer_Phone'),
                    'email' => $request->input('vpc_Customer_Email'),
                    'address' => $request->input('vpc_SHIP_Street01'),
                    'note' => $request->input('customer_note'),
                    'order_id' => $current_order->id,
                ];
                $ship->create($data_ship);

                /*LUU GIO HANG CHI TIET*/
                $cart = Cart::getContent();
                foreach($cart as $item){
                    $product_array = explode('_',$item->id);
                    $product_id = $product_array[1];

                    $product = $this->product->find($product_id);
                    $product->stock = $product->stock - 1;
                    $product->save();

                    $current_order->products()->attach($product_id, ['quantity'=>$item->quantity, 'unit_price'=>'VND']);
                }
                $pr->quantity = $pr->quantity - 1;
                $pr->save();


                Cart::clearCartConditions();
                Cart::clear();

                return redirect()->route('client.payment_success.thank')->with('success',true);
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

    public function getThankyou(){
        if(session('success')){
            return view('Client::pages.product.payment_success');
        }
        return redirect()->route('client.home');
    }



    /*AJAX*/
    /*CHANGE ATTRIBUTE VALUE*/
    public function ajaxChangeAttributeValue(Request $request)
    {
        if(!$request->ajax()){
            return abort(404);
        }else{
            $product_id = $request->input('value_id');
            $product_ajax = $this->product->find($product_id);

            $price = $product_ajax->discount ? number_format($product_ajax->discount) : number_format($product_ajax->price);
            $content = strip_tags($product_ajax->content);
            $photo_display = view('Client::extensions.photo_product')->with('product', $product_ajax)->render();

            return response()->json(['error' => false, 'data'=>$product_ajax, 'price' => $price, 'content'=>$content, 'photo'=>$photo_display], 200);

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
