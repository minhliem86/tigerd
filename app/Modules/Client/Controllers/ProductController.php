<?php

namespace App\Modules\Client\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\AttributeValueRepository;
use Validator;
use Cart;
use Auth;
use Session;
use Cache;
use DB;
use Carbon\Carbon;
use App\Repositories\PromotionRepository;
use App\Repositories\PaymentMethodRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ShipAddressRepository;
use App\Repositories\TransactionRepository;

use App\Modules\Client\Events\SendMail;
use App\Events\EmailTemplateEvent;

class ProductController extends Controller
{
    protected $cate;
    protected $product;
    protected $value;
    protected $order;
    protected $ship_address;
    protected $promotion;

    protected $merchant;
    protected $access;
    protected $secure;

    public function __construct(CategoryRepository $cate, ProductRepository $product, AttributeValueRepository $value, OrderRepository $order, ShipAddressRepository $ship_address, PromotionRepository $promotion)
    {
        $this->cate = $cate;
        $this->product = $product;
        $this->value = $value;
        $this->order = $order;
        $this->ship_address = $ship_address;
        $this->promotion = $promotion;

        $this->merchant = env('OP_MERCHANT');
        $this->access = env('OP_ACCESS');
        $this->secure = env('OP_SECURE');

        $this->auth = Auth::guard('customer');
//        $this->middleware('client_checklogin',
//            ['only'=>['doPayment','getPayment', 'responseFormOnePay']]
//        );
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
            'vpc_SHIP_City' => 'required',
            'vpc_SHIP_Provice' => 'required',
            'ward' => 'required',
            'AVS_Street01' => 'required',
            'payment_method' => 'required'
        ];
    }

    private function _messagePayment(){
        return [
            'customer_name.required' => 'Vui lòng nhập Tên',
            'vpc_Customer_Phone.required' => 'Vui lòng nhập Số điện thoại',
            'vpc_Customer_Email.required' => 'Vui lòng nhập Email',
            'vpc_Customer_Email.email' => 'Vui lòng nhập định dạng Email',
            'AVS_Street01.required' => 'Vui lòng nhập địa chỉ giao hàng',
            'vpc_SHIP_City.required' => 'Vui lòng chọn Thành Phố',
            'vpc_SHIP_Provice.required' => 'Vui lòng chọn Quận/Huyện',
            'ward.required' => 'Vui lòng chọn Phường/Xã',
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

    public function getAllProduct()
    {
        $all_cate = $this->cate->all(['id', 'name', 'slug']);
        $allProduct = $this->product->getAllProduct(['id','slug','name','price','discount','img_url','stock']);
        $hotProduct = $this->product->hotProduct(['id', 'slug', 'name' , 'img_url']);
        return view('Client::pages.product.all_product', compact('allProduct', 'all_cate', 'hotProduct'));
    }

    public function getProduct(Request $request, $slug)
    {
        $product = $this->product->getProductBySlug($slug,['id','name', 'slug', 'description', 'content', 'sku_product', 'price', 'discount', 'img_url','category_id','type'], ['categories','photos', 'attributes','testimonials']);
        $meta = $product->meta_configs()->first();
        if(count($product)){
            $relate_product = $this->product->relateProduct([$product->id], ['id', 'img_url', 'name','slug', 'price', 'discount','category_id', 'default'],['attributes', 'product_links']);
            $ip = $request->ip();
            $info_cache = $ip . '_' .$slug;
            if(!Cache::has($info_cache)){
                $product->count_number  = $product->count_number + 1 ;
                $product->save();

                Cache::remember($info_cache,15,function() use ($product){
                   return $product->count_number;
                });
            }

            return view('Client::pages.product.detail', compact('product', 'relate_product', 'meta'));
        }
        return abort(404);
    }

    public function addToCart(Request $request)
    {
        $valid = Validator::make($request->all(), [ 'quantity' => 'required|min:1'] , [ 'quantity.required' => 'Vui lòng chọn số lượng sản phẩn cần mua.', 'quantity.min' => 'Số lượng tối thiểu là 1.']);
        if($valid->fails()){
            return redirect()->back()->withErrors($valid,'addToCart');
        }
        $id = $request->input('product_id');
        $product = $this->product->find($id, ['id', 'name','price', 'discount', 'img_url'], ['attributes']);
        if(count($product)){
            $str_cart_id = $product->id.'-';
            $arr_att = [];
            if($request->has('att_value')){
                $arr_value = $request->input('att_value');
                foreach($arr_value as $key =>$item_value){

                    $i_value = $this->value->find($item_value);
                    $arr_att[$i_value->attributes->name] = $i_value->value;
                    $str_cart_id = $str_cart_id.\LP_lib::unicode($i_value->value);
                    if($item_value != end($arr_value)){
                        $str_cart_id += '-';
                    }
                }
            }
            $att_img = [
                'img_url' => $product->img_url,
            ];

            $att = $arr_att + $att_img;

            $data = [
                'id' => $str_cart_id,
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
            return redirect()->route('client.product.showAll')->with('error','Giỏ hàng của bạn đang rỗng. Vui lòng chọn sản phẩm.');
        }
        $cart = $cart = Cart::getContent();
        return view('Client::pages.product.cart', compact('cart'));
    }

    public function clearCart()
    {
        Cart::clear();
        Cart::clearCartConditions();
        return redirect()->route('client.product.showAll')->with('error','Giỏ hàng của bạn đã được xóa.');;
    }

    public function getPayment(Request $request, PaymentMethodRepository $paymentMethod)
    {
        if(Cart::isEmpty()){
            return redirect()->route('client.home')->with('error','Giỏ hàng của bạn đang rỗng. Vui lòng chọn sản phẩm.');
        }
        $cart = Cart::getContent();
        $city = DB::table('cities')->orderBy('order','DESC')->lists('name', 'code');
        $pm = $paymentMethod->query(['id', 'name','description'])->where('slug','cod')->get();
        return view('Client::pages.product.payment', compact('cart', 'pm', 'city'));
    }

     public function applyPromotion(Request $request, PromotionRepository $promotion)
    {
        if(!$request->ajax()){
            abort(404);
        }else{
            $promotion_valid = Cart::getConditionsByType('discount');
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
//        if(!$this->auth->check()){
//            return redirect()->route('client.auth.login')->with('error','Vui lòng đăng nhập.');
//        }
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
                    $pr = [];
                    $promotion_id = '';
                }
                /*LUU GIO HANG*/
                $order_id = \LP_lib::unicodenospace($request->input('customer_name')).'_'.time();
                $data = [
                    'order_name' => $order_id,
                    'shipping_cost' => $request->input('shippingcost'),
                    'total' => Cart::getTotal(),
                    'customer_id' => $this->auth->check() ? $this->auth->user()->id : 2 ,
                    'promotion_id' => $promotion_id,
                    'paymentmethod_id' => 1,
                    'shipstatus_id' => 1,
                    'paymentstatus_id' =>1,
                ];
                $current_order = $this->order->create($data);

                /*LUU SHIP ADDRESS*/
                $data_ship = [
                    'fullname' => $request->customer_name,
                    'phone' => $request->input('vpc_Customer_Phone'),
                    'email' => $request->input('vpc_Customer_Email'),
                    'city' => $request->input('vpc_SHIP_City'),
                    'district' => $request->input('vpc_SHIP_Provice'),
                    'ward' => $request->input('ward'),
                    'address' => $request->input('AVS_Street01'),
                    'note' => $request->input('customer_note'),
                    'order_id' => $current_order->id,
                ];
                $shipAddress = $this->ship_address->create($data_ship);

                /*LUU GIO HANG CHI TIET*/
                $cart = Cart::getContent();
                foreach($cart as $item){
                    $product_id = $item->id;
                    $product = $this->product->find($product_id);
                    $product->stock = $product->stock - 1;
                    $product->save();

                    $current_order->products()->attach($product_id, ['quantity'=>$item->quantity, 'unit_price'=>'VND', 'attribute' => json_encode($item->attributes, JSON_UNESCAPED_UNICODE)]);
                }
                if(count($pr)){
                    $pr->quantity = $pr->quantity - 1;
                    $pr->save();
                }

                event(new SendMail(['cart' => $cart, 'shipping_cost' =>$request->input('shippingcost'), 'name'=> $request->customer_name, 'information_shipper' => $shipAddress, 'order_no' =>  $order_id, 'order_date' => $current_order->created_at ],   $request->input('vpc_Customer_Email'), 'Xác nhận đặt hàng thành công. Đơn hàng #'.$order_id));

                event(new EmailTemplateEvent('Client::emails.notifyAdmin', [],env("MAIL_USERNAME"), env('ADMIN_PAGE_EMAIL'), 'Thông Báo - Khách Đặt Hàng' ));

                Cart::clearCartConditions();
                Cart::clear();

                return redirect()->route('client.payment_success.thank')->with('success','Đặt hàng thành công.');
                break;

            case '2' :
                if($request->has('promotion_name')){
                    $pr = $promotion->query(['id', 'name','status','sku_promotion'])->where('status','1')->where('sku_promotion', $request->input('promotion_name'))->first();
                    $promotion_id = $pr->id;
                }else{
                    $promotion_id = '';
                }

                $data_ship = [
                    'fullname' => $request->customer_name,
                    'phone' => $request->input('vpc_Customer_Phone'),
                    'email' => $request->input('vpc_Customer_Email'),
                    'city' => $request->input('vpc_SHIP_City'),
                    'district' => $request->input('vpc_SHIP_Provice'),
                    'ward' => $request->input('ward'),
                    'address' => $request->input('AVS_Street01'),
                    'note' => $request->input('customer_note'),
                ];
                \Session::put('promotion_id', $promotion_id);
                \Session::put('ship_address', $data_ship);

                $order_id = \LP_lib::unicodenospace($request->input('customer_name')).'_'.time();
                $customer_id = $this->auth->check() ? $this->auth->user()->firstname . '_'. $this->auth->user()->id . '_'. time() : 2 ;
                $onepay = $this->setupOnePay();
                $refer = $onepay->build_link_global($request->all(),$order_id, Cart::getTotal(), $order_id, route('client.responsePayment',$promotion_id),  $customer_id);
                return redirect($refer);
                break;
        }


    }

    public function responseFormOnePay(Request $request, TransactionRepository $transaction)
    {
        $onepay = $this->setupOnePay();

        $hashValidated = $onepay->check_response($request->all());

        if($hashValidated === 'CORRECT' && $request->vpc_TxnResponseCode == "0"){
            //thanh cong
            /*LUU GIO HANG*/
            $data_order = [
                'order_name' => $request->input('vpc_OrderInfo'),
                'shipping_cost' => 0,
                'total' => Cart::getTotal(),
                'customer_id' => $this->auth->check() ? $this->auth->user()->id : 2 ,
                'promotion_id' => session('promotion_id'),
                'paymentmethod_id' => 2,
                'shipstatus_id' => 1,
                'paymentstatus_id' =>2,
            ];
            $order = $this->order->create($data_order);

            /*LUU THONG TIN SHIP*/
            $data_ship = session('ship_address');
            $data_ship['order_id'] = $order->id;

            $this->ship_address->create($data_ship);
            if(session('promotion_id')){
                $promotion = $this->promotion->find(session('promotion_id'));
                $promotion->quantity = $promotion->quantity - 1;
                $promotion->save();
            }
            $cart = Cart::getContent();
            foreach($cart as $item){
                $product_id = $item->id;
                $product = $this->product->find($item->id);
                $product->stock = $product->stock - 1;
                $product->save();

                $order->products()->attach($product_id, ['quantity'=>$item->quantity, 'unit_price'=>'VND', 'attribute' => json_encode($item->attributes, JSON_UNESCAPED_UNICODE) ]);
            }

            /*LUU TRANSACTION*/
            $data_transaction = [
                'order_id' => $order->id,
                'order_name' => $request->input('vpc_MerchTxnRef'),
                'transaction_id' => $request->input('vpc_TransactionNo'),
                'merchant_code' => $request->input('vpc_MerchTxnRef'),
                'total' => $request->input('vpc_Amount')/100,
            ];
            $transaction->create($data_transaction);

            event(new SendMail($cart,  $this->auth->check() ? $this->auth->user()->id : 2));

            Session::forget('promotion_id');
            Session::forget('ship_address');

            Cart::clearCartConditions();
            Cart::clear();

            return redirect()->route('client.payment_success.thank')->with('success','Mua hàng thành công.');

        }elseif($hashValidated=="INVALID HASH" && $request->vpc_TxnResponseCode == "0"){
            // pending
            return redirect()->route('client.payment')->with('error','Giao dịch bị gián đoạn. Vui lòng thực hiện lại giao dịch khác.');
        }else{
            //thatbai
            $error_message = $onepay->getResponseDescription($request->vpc_TxnResponseCode);
            return redirect()->route('client.payment')->with('error',$error_message);
        }
    }

    public function getThankyou(){
        if(session('success')){
            return view('Client::pages.product.payment_success');
        }
        return redirect()->route('client.home');
    }

    /*SHIPPING LOAD*/
    public function loadShippingCost(Request $request)
    {
        if(!$request->ajax()){
            abort(404);
        }else{
            $city_id = $request->input('city_id');
            $district_id = $request->input('district_id');
            $payment_method_id = $request->input('payment_method_id');

            $condition_ship = Cart::getCondition('shippingCost');
            if($condition_ship){
                Cart::removeCartCondition('shippingCost');
            }

            if($city_id){
                if($city_id != 79){
                    switch ($payment_method_id){
                        case '1' :
                        /*COD*/
                            $shipping = new \Darryldecode\Cart\CartCondition(
                                [
                                    'name' => 'shippingCost',
                                    'type' => 'shipping',
                                    'target' => 'subtotal',
                                    'value' => '50000',
                                ]
                            );
                            Cart::condition($shipping);
                            $total = number_format(Cart::getTotal());
                            return response()->json(['total' => $total, 'shippingCost' => number_format(50000), 'value_ship' => 50000], 200);
                        case '2' :
                        /*PAYMENT ONLINE*/
                            $shipping = new \Darryldecode\Cart\CartCondition(
                                [
                                    'name' => 'shippingCost',
                                    'type' => 'shipping',
                                    'target' => 'subtotal',
                                    'value' => '40000',
                                ]
                            );
                            Cart::condition($shipping);
                            $total = number_format(Cart::getTotal());
                            return response()->json(['total' => $total, 'shippingCost' => number_format(40000), 'value_ship' => 40000], 200);
                    }
                }else{
                    $shipping = \DB::table('shipping_costs')->where('district_id',$district_id)->select('cost')->first();
                    switch ($shipping->cost ){
                        /*CASE 30k*/
                        case '30000' :
                            $shipping = new \Darryldecode\Cart\CartCondition(
                                [
                                    'name' => 'shippingCost',
                                    'type' => 'shipping',
                                    'target' => 'subtotal',
                                    'value' => '30000',
                                ]
                            );
                            Cart::condition($shipping);
                            $total = number_format(Cart::getTotal());
                            return response()->json(['total' => $total, 'shippingCost' => number_format(30000), 'value_ship' => 30000], 200);
                        /*CASE 40k*/
                        case '40000' :
                            $shipping = new \Darryldecode\Cart\CartCondition(
                                [
                                    'name' => 'shippingCost',
                                    'type' => 'shipping',
                                    'target' => 'subtotal',
                                    'value' => '40000',
                                ]
                            );
                            Cart::condition($shipping);
                            $total = number_format(Cart::getTotal());
                            return response()->json(['total' => $total, 'shippingCost' => number_format(40000), 'value_ship' => 40000], 200);
                        /*CASE 50k*/
                        case '50000' :
                            $shipping = new \Darryldecode\Cart\CartCondition(
                                [
                                    'name' => 'shippingCost',
                                    'type' => 'shipping',
                                    'target' => 'subtotal',
                                    'value' => '50000',
                                ]
                            );
                            Cart::condition($shipping);
                            $total = number_format(Cart::getTotal());
                            return response()->json(['total' => $total, 'shippingCost' => number_format(50000), 'value_ship' => 50000], 200);
                        /*CASE 20k*/
                        default :
                            $shipping = new \Darryldecode\Cart\CartCondition(
                                [
                                    'name' => 'shippingCost',
                                    'type' => 'shipping',
                                    'target' => 'subtotal',
                                    'value' => '20000',
                                ]
                            );
                            Cart::condition($shipping);
                            $total = number_format(Cart::getTotal());
                            return response()->json(['total' => $total, 'shippingCost' => number_format(20000), 'value_ship' => 20000], 200);
                    }
                }
            }

        }
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
            $content = $product_ajax->content;
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

    public function getDistrict(Request $request)
    {
        if(!$request->ajax()){
            abort(404);
        }else{
            $city_id = $request->input('city_id');
            $district = DB::table('district')->where('parent_code', $city_id)->orderBy('order','DESC')->lists('name_with_type', 'code');
            $view = view('Client::ajax.district', compact('district'))->render();
            return response()->json(['error' => false, 'data'=> $view]);
        }
    }
    public function getWard(Request $request)
    {
        if(!$request->ajax()){
            abort(404);
        }else{
            $district_id = $request->input('district_id');
            $ward = DB::table('wards')->where('parent_code', $district_id)->orderBy('order','DESC')->lists('name_with_type', 'code');
            $view = view('Client::ajax.ward', compact('ward'))->render();
            return response()->json(['error' => false, 'data'=> $view]);
        }
    }

    public function chosenAttributeAjax(Request $request)
    {
        !$request->ajax() ? abort(404) :
            $value_id = $request->get('value_id');
            $att_value = $this->value->find($value_id);
            if($att_value->photos->isEmpty()){
               return response()->json(['error' => true],200);
            }else{
                $view = view('Client::extensions.photo_product')->with(['product' => $att_value])->render();
                return response()->json(['error' => false, 'data' => $view],200);
            }

    }
}
