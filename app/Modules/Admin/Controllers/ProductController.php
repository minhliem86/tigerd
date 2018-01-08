<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\AttributeRepository;
use App\Repositories\AttributeValueRepository;
use App\Repositories\PhotoRepository;
use App\Repositories\Eloquent\CommonRepository;
use Datatables;
use Validator;

class ProductController extends Controller
{
    protected $_big;
    protected $_small;
    protected $_replacePath;
    protected $_removePath;
    protected $productRepo;
    protected $common;
    protected $photo;

    public function __construct(ProductRepository $product, CommonRepository $common, PhotoRepository $photo)
    {
        $this->productRepo = $product;
        $this->common = $common;
        $this->photo = $photo;
        $this->_replacePath = env('REPLACE_PATH_UPLOAD') ? env('REPLACE_PATH_UPLOAD') : '';
        $this->_removePath = asset('public/upload/');
        $this->_big = env('THUMBNAIL_PATH_BIG') ? env('THUMBNAIL_PATH_BIG') : '';
        $this->_small = env('THUMBNAIL_PATH_SMALL') ? env('THUMBNAIL_PATH_SMALL') : '';
    }

    public $rules = [
        'category_id'=> 'required',
        'sku_product' => 'required|min:2|max:5|unique:products,sku_product',
        'price' => 'required',
        'stock_quality' => 'required'
    ];

    public $messages = [
        'category_id.required' => 'Vui lòng chọn Danh Mục Sản Phẩm',
        'sku_product.required' => 'Vui lòng nhập Mã Sản Phẩm',
        'sku_product.min' => 'Mã Sản Phẩm tối thiểu 2 ký tự hoa',
        'sku_product.max' => 'Mã Sản Phẩm tối đa 5 ký tự hoa',
        'sku_product.unique' => 'Mã Sản Phẩm này đã tồn tại',
        'price.required' => 'Vui lòng nhập Giá sản phẩm',
        'stock_quality.required' => 'Vui lòng nhập Số lượng nhập kho'
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin::pages.product.index');
    }

    public function getData(Request $request)
    {
//        $product = DB::table('products')->join('categories', 'products.category_id', '=','categories.id')->select(['products.id', 'products.title', 'products.avatar_img', 'products.price', 'products.order', 'products.status', 'products.hot']);

        $product = $this->productRepo->query(['products.id as id', 'products.name as name', 'products.sku_product as sku_product', 'products.price as price', 'products.discount as discount', 'products.stock_quality as quality', 'products.img_url as img_url', 'products.hot as hot' ,  'products.order as order', 'products.status as status', 'categories.name as cate_name'])->join('categories', 'categories.id', '=', 'products.category_id');
        return Datatables::of($product)
            ->addColumn('action', function($product){
                return '<a href="'.route('admin.product.edit', $product->id).'" class="btn btn-info btn-xs inline-block-span"> Edit </a>
            <form method="POST" action=" '.route('admin.product.destroy', $product->id).' " accept-charset="UTF-8" class="inline-block-span">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="'.csrf_token().'">
                           <button class="btn  btn-danger btn-xs remove-btn" type="button" attrid=" '.route('admin.product.destroy', $product->id).' " onclick="confirm_remove(this);" > Remove </button>
           </form>' ;
            })->editColumn('order', function($product){
                return "<input type='text' name='order' class='form-control' data-id= '".$product->id."' value= '".$product->order."' />";
            })->editColumn('status', function($product){
                $status = $product->status ? 'checked' : '';
                $product_id =$product->id;
                return '
             <label class="toggle">
                <input type="checkbox" name="status" value="1" '.$status.'   data-id ="'.$product_id.'">
                <span class="handle"></span>
              </label>
          ';
            })->editColumn('hot', function($product){
                $hot = $product->hot ? 'checked' : '';
                $product_id =$product->id;
                return '
            <label class="toggle">
               <input type="checkbox" name="hot" value="1" '.$hot.'   data-id ="'.$product_id.'">
               <span class="handle"></span>
             </label>
         ';
            })->editColumn('price', function($product){
                $price = number_format($product->price);
                return $price;
            })->editColumn('img_url',function($product){
                return '<img src="'.asset($product->img_url).'" width="80" class="img-responsive">';
            })->filter(function($query) use ($request){
                if (request()->has('name')) {
                    $query->where('products.name', 'like', "%{$request->input('name')}%")->orWhere('products.sku_product', 'like', "%{$request->input('name')}%");
                }
            })->setRowId('id')->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CategoryRepository $category, AttributeRepository $attribute )
    {
        if(!$category->query()->count()){
            return redirect()->route('admin.category.index')->with('error','Vui lòng Tạo danh mục sản phẩm');
        }
        $cate = $category->query(['id', 'name'])->lists('name', 'id')->toArray();
        $attribute_list = $attribute->all(['id', 'name', 'slug']);
        return view('Admin::pages.product.create', compact('cate', 'attribute_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CategoryRepository $cate)
    {
        $valid = Validator::make($request->all(), $this->rules, $this->messages);
        if($valid->fails()){
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }
        if($request->has('img_url')){
            $img_url = $this->common->getPath($request->input('img_url'), $this->_replacePath);
        }else{
            $img_url = "";
        }

        $sku_cate = $cate->find($request->input('category_id'));
        $sku_product = $sku_cate->sku_cate. '_' .\Str::upper(trim($request->input('sku_product')));
        $order = $this->productRepo->getOrder();
        $data = [
            'name' => $request->input('name'),
            'slug' => \LP_lib::unicode($request->input('name')),
            'description' => $request->input('description'),
            'content' => $request->input('content'),
            'sku_product' => $sku_product,
            'price' => $request->input('price'),
            'discount' => $request->input('discount'),
            'stock_quality' => $request->input('stock_quality'),
            'img_url' => $img_url,
            'order' => $order,
            'category_id' => $request->input('category_id'),
        ];
        $product = $this->productRepo->create($data);

        if($request->has('meta_config')){
            if($request->has('meta_img')){
                $meta_img = $this->common->getPath($request->input('meta_img'), $this->_replacePath);
            }else{
                $meta_img = "";
            }
            $data = [
                'meta_keywords' => $request->input('meta_keywords'),
                'meta_description' => $request->input('meta_description'),
                'meta_img' => $meta_img,
            ];
            $product->meta_configs()->save(new \App\Models\MetaConfiguration($data));
        }
        if($request->file('img_detail')){
            $data_photo = [];
            foreach($request->file('thumb-input') as $k=>$thumb){
                $bigsize = $this->common->uploadImage($request, $thumb, $this->_big,$resize = false);
                $smallsize = $this->common->createThumbnail($bigsize,$this->_small,100, 100);

                $order = $this->photo->getOrder();
                $data = new \App\Models\Photo(
                    [
                    'img_url' => $this->common->getPath($bigsize, $this->_replacePath, $this->_removePath),
                    'thumb_url' => $this->common->getPath($smallsize, $this->_replacePath, $this->_removePath),
                    'order'=>$order,
                    ]
                );
                array_push($data_photo, $data);
            }
            $product->photos()->saveMany($data_photo);
        }

        if($request->has('attribute_section')){
           if($request->has('att')){
               $data_att = $request->input('att');
               $product->attributes()->attach($data_att);
               if($request->has('att_value')){
                   $data_value = $request->input('att_value');
                   $product->values()->attach($data_value);
               }
           }
        }
        return redirect()->route('admin.product.index')->with('success','Created !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($this->productRepo->make(['photos'])->find(19));
        $inst = $this->productRepo->find($id,['*'],['photos']);
        return view('Admin::pages.product.edit', compact('inst'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $img_url = $this->common->getPath($request->input('avatar_img'));
        $meta_image = $this->common->getPath($request->input('meta_image'));

//        $data = [
//                'name' => $request->input('name'),
//                'slug' => \LP_lib::unicode($request->input('name')),
//                'description' => $request->input('description'),
//                'content' => $request->input('content'),
//                'price' => $request->input('price'),
//                'category_id' => 1,
//                'avatar_img' => $img_url,
//                'meta_keywords' => $request->input('meta_keywords'),
//                'meta_description' => $request->input('meta_description'),
//                'meta_images' => $meta_image,
//                'order' => $request->input('order'),
//                'status' => $request->input('status'),
//        ];
//        $product = $this->productRepo->update($data, $id);
//
//        if($request->hasFile('thumb-input')){
//          foreach($request->file('thumb-input') as $k=>$thumb){
//            $img = $this->common->uploadImage($request, $thumb, $this->_bigsize,$resize = false);
//            $thumbnail = $this->common->createThumbnail($img,$this->_thumbnail,100, 100);
//
//            $order = $this->photo->getOrder();
//            $product->photos()->save(new \App\Models\Photo([
//              'img_url' => $this->common->getPath($img, asset('public/upload')),
//              'thumb_url' => $this->common->getPath($thumbnail, asset('public/upload')),
//              'order'=>$order,
//            ]));
//          }
//        }
//        return redirect()->route('admin.product.index')->with('success', 'Updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->productRepo->delete($id);
        return redirect()->route('admin.product.index')->with('success', 'Deleted !');
    }

    /*DELETE ALL*/
    public function deleteAll(Request $request)
    {
        if(!$request->ajax()){
            abort(404);
        }else{
            $data = $request->arr;
            $response = $this->productRepo->deleteAll($data);
            return response()->json(['msg' => 'ok']);
        }
    }

    /*UPDATE ORDER*/
    public function postAjaxUpdateOrder(Request $request)
    {
        if(!$request->ajax())
        {
            abort('404', 'Not Access');
        }else{
            $data = $request->input('data');
            foreach($data as $k => $v){
                $upt  =  [
                    'order' => $v,
                ];
                $obj = $this->productRepo->find($k);
                $obj->update($upt);
            }
            return response()->json(['msg' =>'ok', 'code'=>200], 200);
        }
    }

    /*CHANGE STATUS*/
    public function updateStatus(Request $request)
    {
        if(!$request->ajax()){
            abort('404', 'Not Access');
        }else{
            $value = $request->input('value');
            $id = $request->input('id');
            $cate = $this->productRepo->find($id);
            $cate->status = $value;
            $cate->save();
            return response()->json([
                'mes' => 'Updated',
                'error'=> false,
            ], 200);
        }
    }

    public function updateHotProduct(Request $request)
    {
        if(!$request->ajax()){
            abort('404', 'Not Access');
        }else{
            $value = $request->input('value');
            $id = $request->input('id');
            $cate = $this->productRepo->find($id);
            $cate->hot = $value;
            $cate->save();
            return response()->json([
                'mes' => 'Updated',
                'error'=> false,
            ], 200);
        }
    }

    /* REMOVE CHILD PHOTO */
    public function AjaxRemovePhoto(Request $request)
    {
        if(!$request->ajax()){
            abort('404', 'Not Access');
        }else{
            $id = $request->input('id_photo');
            $this->photo->delete($id);
            return response()->json([
                'mes' => 'Deleted',
                'error'=> false,
            ], 200);
        }
    }

    /* UPDATE CHILD PHOTO */
    public function AjaxUpdatePhoto(Request $request)
    {
        if(!$request->ajax()){
            abort('404', 'Not Access');
        }else{
            $id = $request->input('id_photo');
            $order = $request->input('value');
            $photo = $this->photo->update(['order'=>$order], $id);

            return response()->json([
                'mes' => 'Update Order',
                'error'=> false,
            ], 200);
        }
    }

    /*ADD ATTRIBUTE AJAX*/
    public function postAddAttribute(Request $request, AttributeRepository $attribute)
    {
        if(!$request->ajax()){
            abort('404', 'Not Access');
        }else{
            $data = [
                'name' => $request->input('name_att'),
                'slug' => \LP_lib::unicodenospace($request->input('name_att')),
                'description' => $request->input('att_description'),
            ];
            $attribute->create($data);
            $attribute_list = $attribute->all(['id','name','slug'],['attribute_values']);
            $view = view('Admin::ajax.attribute.attribute', compact('attribute_list'))->render();
            return response()->json(['rs'=>'ok', 'data' => $view], 200);
        }
    }

    /*CREATE ATTRIBUTE VALUE*/
    public function createAttValue(Request $request, AttributeValueRepository $attvalue, AttributeRepository $att)
    {
        if(!$request->ajax()){
            abort('404', 'Not Access');
        }else{
            $att_id = $request->input('att_id');

            $att_value = trim($request->input('value'));
            $order = $attvalue->getOrder();
            $data = [
                'value' => $att_value,
                'order' => $order,
                'attribute_id' => $att_id
            ];
            $attValue = $attvalue->create($data);
            $item_attr = $att->find($att_id);
            $view = view('Admin::ajax.attribute.attribute_value', compact('item_attr'))->render();
            return response()->json(['error'=>false, 'data' => $view ]);
        }
    }

    /*REMOVE ATTRIBUTE OR VALUE*/
    public function removeAttribute(Request $request, AttributeRepository $att )
    {
        if(!$request->ajax()){
            abort('404', 'Not Access');
        }else {
            $array_att = $request->input('arr_att');
            if(count($array_att)){
                $att->deleteAll($array_att);
                $attribute_list = $att->all(['id','name','slug'],['attribute_values']);
                $view = view('Admin::ajax.attribute.attribute', compact('attribute_list'))->render();
                return response()->json(['error'=>false, 'mes' => 'Thuộc tính đã được xóa thành công', 'data' => $view], 200);
            }else{
                return response()->json(['error'=>true, 'mes' => 'Vui lòng chọn thuộc tính cần xóa'], 200);
            }
        }
    }

    /*REMOVE ATTRIBUTE VALUE*/
    public function removeAttributeValue(Request $request, AttributeValueRepository $attribute_value, AttributeRepository $att)
    {
        if(!$request->ajax()){
            abort('404', 'Not Access');
        }else{
            $id = $request->input('id');
            $att_id = $request->input('att_id');
            $attribute_value->delete($id);
            $item_attr = $att->find($att_id);
            $view = view('Admin::ajax.attribute.attribute_value', compact('item_attr'))->render();
            return response()->json(['error'=>false, 'mes' => 'Giá trị đã được xóa', 'data'=>$view], 200);
        }
    }
}
