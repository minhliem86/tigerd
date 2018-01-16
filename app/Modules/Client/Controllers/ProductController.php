<?php

namespace App\Modules\Client\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Validator;

class ProductController extends Controller
{
    protected $cate;
    protected $product;

    public function __construct(CategoryRepository $cate, ProductRepository $product)
    {
        $this->cate = $cate;
        $this->product = $product;
    }

    private function _rulesAddToCart()
    {
        return [
          'price' => 'required|min:1',
            'quantity' => 'required|min:1|max:10',
            'att_value_.*'=> 'required'
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
        $valid = Validator::make($request->all(),$this->_rulesAddToCart());
        if($valid->fails()){
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }

    }
}
