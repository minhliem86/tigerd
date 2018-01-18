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
            $array_attribute = [];

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
}
