<?php

namespace App\Modules\Client\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use App\Repositories\PromotionRepository;
use App\Repositories\PaymentMethodRepository;
use Cart;

class SanPhamController extends Controller
{
    protected $product;

    public function __construct(ProductRepository $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        $product = $this->product->all();
        return view('Client::pages.product', compact('product'));
    }

    public function getCart(Request $request)
    {
        if(Cart::isEmpty()){
            return redirect()->route('client.product');
        }
        $cart = $cart = Cart::getContent();
        return view("Client::pages.cart", compact('cart'));
    }

    public function getCartRemove($id)
    {
        Cart::remove($id);
        if(Cart::isEmpty())
            Cart::clearCartConditions();
        return redirect()->back();
    }

    public function getCartRemoveAll()
    {
        Cart::clear();
        Cart::clearCartConditions();
        return redirect()->route('client.product');
    }


    public function addToCart(Request $request)
    {
        if(!$request->ajax()){
            abort('404');
        }else{
            $product_id = $request->input('id');
            $product = $this->product->find($product_id);
            Cart::add([
                'id' => $product_id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity'=> 1,
            ]);
            $cart_quanlity = Cart::getTotalQuantity();
            return response()->json(['quantity' => $cart_quanlity, 'error'=>false], 200);
        }
    }

    public function payment(Request $request, PaymentMethodRepository $payment_method)
    {
        if(Cart::isEmpty()){
            return redirect()->route('client.product');
        }
        $cart = Cart::getContent();
        $payment_method = $payment_method->all(['id', 'name']);
        return view('Client::pages.payment', compact('cart', $payment_method));
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

                        $pr->quality = $pr->quality - 1;
                        $pr->num_use = $pr->num_use + 1;
                        $pr->save();

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

    public function doPayment(Request $request)
    {

        $onepay = new \ClassOnepay();

        $onepay->setupMerchant('TESTONEPAY', '6BEB2546', '6D0870CDE5F24F34F3915FB0045120DB');

        $refer = $onepay->build_link_LP($request->all());

//        return $refer;
        return redirect($refer);

    }

    public function responseFormOnePay()
    {
        $onepay = new \ClassOnepay();
//
        $onepay->setupMerchant('TESTONEPAY', '6BEB2546  ', '6D0870CDE5F24F34F3915FB0045120DB');
//        dd($_GET);

        $hashValidated = $onepay->validate($_GET);

        dd($hashValidated);
    }
}
