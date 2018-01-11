<?php

namespace App\Modules\Client\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use App\Repositories\PromotionRepository;
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



    public function cart(Request $request)
    {
        $cart = $cart = Cart::getContent();
        return view("Client::pages.cart", compact('cart'));
    }

    public function payment(Request $request)
    {
        $cart = Cart::getContent();
        return view('Client::pages.payment', compact('cart'));
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

    public function applyPromotion(Request $request, PromotionRepository $promotion)
    {
        if(!$request->ajax()){
            abort(404);
        }else{
            $promote_code = $request->input('pr_code');
            $pr = $promotion->query()->where('sku_promotion',$promote_code)->where('status',1)->select('name','target','value', 'value_type')->first();
            if(count($pr)){
                if(Cart::getCondition($pr->name)){
                    $condition = Cart::getCondition($pr->name);
                }else{
                    $cond = new \Darryldecode\Cart\CartCondition(
                        [
                            'name' => $pr->name,
                            'type' => 'discount',
                            'target' => $pr->target,
                            'value' => $pr->value_type === '%' ? $pr->value.$pr->value_type : $pr->value,
                        ]
                    );
                    Cart::condition($cond);
                    $condition = Cart::getCondition($pr->name);
                }

                $subTotal = Cart::getSubTotal();
                $subTotalAfterCondition = $condition->getCalculatedValue($subTotal);

                $total = Cart::getTotal();

                $pr->quality = $pr->quality - 1;
                $pr->num_use = $pr->num_use + 1;
                $pr->save();

                return response()->json(['error' => false, 'data' => json_encode(['subtotal' => $subTotalAfterCondition, 'total' => $total, 'pr_value' => $condition->getValue()]), 'message' => 'Mã khuyến mãi đã được áp dụng'], 200);

            }else{
                return response()->json(['error'=>true, 'data'=> null, 'message' => 'Mã khuyến mãi đã hết hạn hoặc không tồn tại'], 200);
            }
        }
    }
}
