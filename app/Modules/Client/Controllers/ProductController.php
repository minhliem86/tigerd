<?php

namespace App\Modules\Client\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\AttributeValueRepository;
use Validator;

class ProductController extends Controller
{
    protected $cate;
    protected $product;
    protected $value;

    public function __construct(CategoryRepository $cate, ProductRepository $product, AttributeValueRepository $value)
    {
        $this->cate = $cate;
        $this->product = $product;
        $this->value = $value;
    }

    private function _rulesAddToCart()
    {
        return [
          'price' => 'required|min:1',
            'quantity' => 'required|min:1|max:10',
            'att_value_.*'=> 'required'
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
          'att_value_*.required' => 'Vui lòng chọn 1 thuộc tính sản phẩm.'
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
            return view('Client::pages.product.detail', compact('product', 'relate_product'));
        }
        return abort(404);
    }

    public function addToCart(Request $request)
    {
        $valid = Validator::make($request->all(),$this->_rulesAddToCart(), $this->_messageAddToCart());
        if($valid->fails()){
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }
        $product = $this->product->find($request->input('product_id'),['id','price','discount'],['attributes', 'values']);
        if(count($product)){
            $data_price_check = [
                $product->discount ? $product->discount :  $product->price,
            ];
            $data_attribute = [];
            if(!$product->attributes->isEmpty() && $request->has('att')){
//                return redirect()->back()->withInput()->with('errors','Xảy ra lỗi trong quá trình xử lý: Sản Phẩm không có thuộc tính.');
                foreach($product->attributes as $item_att){
                    if(!$product->values->isEmpty() && $request->has('tt_value_['.$item_att->slug.']') && in_array($request->has('tt_value_['.$item_att->slug.']'), $product->values()->select('id')->toArray())){
                        $data_attribute[$item_att->name] = $this->value->find($request->input('tt_value_['.$item_att->slug.']'),['id','name'])->name;
                        if($this->value->find($request->input('tt_value_['.$item_att->slug.']'),['id','name'])->value_price){
                            $price = $this->value->find($request->input('tt_value_['.$item_att->slug.']'),['id','name'])->value_price;
                        }else{
                            $price = $request->input('price');
                        }
                    }
                }
            }else{


                if(!in_array($request->input('price'), $data_price_check)){
                    return redirect()->back()->withInput()->with('errors','Xảy ra lỗi trong quá trình xử lý: Giá sản phẩm không chính xác.');
                }
            }




        }

    }
}
