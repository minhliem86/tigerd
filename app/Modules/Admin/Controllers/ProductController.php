<?php

namespace App\Modules\Admin\Controllers;

use App\Models\AttributeValue;
use App\Repositories\MetaRepository;
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
use Session;

class ProductController extends Controller
{
    protected $_big;
    protected $_small;
    protected $_removePath;
    protected $productRepo;
    protected $common;
    protected $photo;

    public function __construct(ProductRepository $product, CommonRepository $common, PhotoRepository $photo)
    {
        $this->productRepo = $product;
        $this->common = $common;
        $this->photo = $photo;

        $this->_removePath = env('REMOVE_PATH');
        $this->_big = env('THUMBNAIL_PATH_BIG') ? env('THUMBNAIL_PATH_BIG') : '';
        $this->_small = env('THUMBNAIL_PATH_SMALL') ? env('THUMBNAIL_PATH_SMALL') : '';
    }

    public $rules = [
        'category_id'=> 'required',
        'name' => 'required|unique:products,name',
        'sku_product' => 'required',
        'price' => 'required',
        'stock' => 'required'
    ];

    public $messages = [
        'category_id.required' => 'Vui lòng chọn Danh Mục Sản Phẩm',
        'sku_product.required' => 'Vui lòng nhập Mã Sản Phẩm',
        'price.required' => 'Vui lòng nhập Giá sản phẩm',
        'stock.required' => 'Vui lòng nhập Số lượng nhập kho'
    ];

    public $rules_edit = [
        'category_id'=> 'required',
        'price' => 'required',
        'stock' => 'required',
        'sku_product' => 'required',
    ];

    public $messages_edit = [
        'category_id.required' => 'Vui lòng chọn Danh Mục Sản Phẩm',
        'sku_product.required' => 'Vui lòng nhập Mã Sản Phẩm',
        'price.required' => 'Vui lòng nhập Giá sản phẩm',
        'stock.required' => 'Vui lòng nhập Số lượng nhập kho'
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin::pages.productv2.index');
    }

    public function getData(Request $request, AttributeRepository $attribute)
    {
        $product = $this->productRepo->query(['products.id as id', 'products.name as name', 'products.sku_product as sku_product', 'products.price as price', 'products.stock as quality', 'products.img_url as img_url', 'products.hot as hot', 'products.order as order', 'products.status as status', 'categories.name as cate_name'])->join('categories', 'categories.id', '=', 'products.category_id')->orderBy('id', 'ASC')->where('visibility', 1)->with(['values']);

        return Datatables::of($product)
            ->addColumn('action', function($product){
                $link = '<a href="'.route('admin.product.edit', $product->id).'" class="btn btn-info btn-xs inline-block-span"> Edit </a>';

                return $link.
            ' <form method="POST" action=" '.route('admin.product.destroy', $product->id).' " accept-charset="UTF-8" class="inline-block-span">
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
            })
            ->editColumn('price', function($product){
                $price = number_format($product->price);
                return $price;
            })
            ->editColumn('img_url',function($product){
                return '<img src="'.asset('public/upload/'.$product->img_url).'" width="80" class="img-responsive">';
            })
            ->filter(function($query) use ($request){
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
    public function create(CategoryRepository $category, AttributeRepository $attribute, AttributeValueRepository $attribute_value )
    {
        if(!$category->query()->count()){
            return redirect()->route('admin.category.index')->with('error','Vui lòng Tạo danh mục sản phẩm');
        }
        $cate = $category->query(['id', 'name'])->lists('name', 'id')->toArray();
        $attribute_list = $attribute->query(['id', 'name'])->lists('name','id')->toArray();
        return view('Admin::pages.productv2.create', compact('cate', 'attribute_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CategoryRepository $cate, AttributeRepository $attribute, AttributeValueRepository $attribute_value )
    {
        $valid = Validator::make($request->all(), $this->rules, $this->messages);
        if($valid->fails()){
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }
        if($request->has('img_url')){
            $img_url = $this->common->getPath($request->input('img_url'));
        }else{
            $img_url = "";
        }

        $sku_product = strtoupper(str_replace(' ','', $request->input('sku_product')));
        $order = $this->productRepo->getOrder();
        $data = [
            'name' => $request->input('name'),
            'slug' => \LP_lib::unicode($request->input('name')),
            'description' => $request->input('description'),
            'content' => $request->input('content'),
            'sku_product' => $sku_product,
            'price' => $request->input('price'),
            'discount' => $request->input('discount'),
            'stock' => $request->input('stock'),
            'img_url' => $img_url,
            'order' => $order,
            'category_id' => $request->input('category_id'),
        ];
        $product = $this->productRepo->create($data);

        if($request->has('meta_config')){
            if($request->has('meta_img')){
                $meta_img = $this->common->getPath($request->input('meta_img'));
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

        $sub_photo = $request->file('thumb-input');

        if($sub_photo[0]) {
            $data_photo = [];
            foreach ($sub_photo as $thumb) {
                $bigSize = $this->common->uploadImage($request, $thumb, $this->_big, $resize = false, null, null, base_path($this->_removePath));
                $smallsize = $this->common->createThumbnail($bigSize, $this->_small, 350, 350, base_path($this->_removePath));

                $order = $this->photo->getOrder();
                $filename = $this->common->getFileName($bigSize);
                $data = new \App\Models\Photo(
                    [
                        'img_url' => $bigSize,
                        'thumb_url' => $smallsize,
                        'order' => $order,
                        'filename' => $filename,
                    ]
                );
                array_push($data_photo, $data);
            }

            $product->photos()->saveMany($data_photo);
        }

        /*ATTRIBUTE PROCESS*/
        $attribute_arr = $request->input('attribute');
        $value_arr = $request->input('att_value');

        if(count($attribute_arr))
        {
            foreach($attribute_arr as $item_attribute) {
                if ($item_attribute) {
                    if (count($value_arr[$item_attribute])) {
                        foreach ($value_arr[$item_attribute] as $item_value) {
                            if ($item_value) {
                                $arr_obj_value[$item_attribute][] = new \App\Models\AttributeValue([
                                    'value' => $item_value,
                                    'product_id' => $product->id,
                                ]);
                            }
                        }

                    }
                    $arr_attribute_id [] = $item_attribute;
                }
            }
            if(count($arr_attribute_id)){
                $product->attributes()->attach($arr_attribute_id);
            }
            if(count($arr_obj_value)){
                foreach($arr_obj_value as $key => $att_val){
                    $att = $attribute->find($key);
                    $att->attribute_values()->saveMany($att_val);
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
    public function edit($id, CategoryRepository $cate, AttributeRepository $attribute)
    {
        $attribute_list = $attribute->query(['id', 'name'])->lists('name','id')->toArray();
        $cate = $cate->query(['id','name'])->lists('name', 'id')->toArray();
        $inst = $this->productRepo->find($id,['*'],['photos','attributes']);
        return view('Admin::pages.productv2.edit', compact('inst', 'cate', 'attribute_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  CategoryRepository $cate, MetaRepository $meta,  AttributeRepository $attribute, AttributeValueRepository $attribute_value,  $id)
    {
        $valid = Validator::make($request->all(), $this->rules_edit, $this->messages_edit);
        if($valid->fails()){
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }
        $img_url = $this->common->getPath($request->input('img_url'));

        $order = $this->productRepo->getOrder();
        $data = [
            'name' => $request->input('name'),
            'slug' => \LP_lib::unicode($request->input('name')),
            'description' => $request->input('description'),
            'content' => $request->input('content'),
            'price' => $request->input('price'),
            'discount' => $request->input('discount'),
            'sku_product' => $sku_product = strtoupper(str_replace(' ','', $request->input('sku_product'))),
            'stock' => $request->input('stock'),
            'img_url' => $img_url,
            'order' => $request->input('order'),
            'status' => $request->input('status'),
            'category_id' => $request->input('category_id'),
        ];

        $product = $this->productRepo->update($data, $id);

        if($request->has('meta_config')){
            $meta_img = $this->common->getPath($request->input('meta_img'));
            $data = [
                'meta_keywords' => $request->input('meta_keywords'),
                'meta_description' => $request->input('meta_description'),
                'meta_img' => $meta_img,
            ];
            if(!$request->has('meta_config_id')){
                $product->meta_configs()->save(new \App\Models\MetaConfiguration($data));
            }
            $meta_config = $meta->update($data,$request->input('meta_config_id'));
        }

        $sub_photo = $request->file('thumb-input');

        if($sub_photo[0]) {
            $data_photo = [];
            foreach ($sub_photo as $thumb) {
                $bigSize = $this->common->uploadImage($request, $thumb, $this->_big, $resize = false, null, null, base_path($this->_removePath));
                $smallsize = $this->common->createThumbnail($bigSize, $this->_small, 350, 350, base_path($this->_removePath));

                $order = $this->photo->getOrder();
                $filename = $this->common->getFileName($bigSize);
                $data = new \App\Models\Photo(
                    [
                        'img_url' => $bigSize,
                        'thumb_url' => $smallsize,
                        'order' => $order,
                        'filename' => $filename,
                    ]
                );
                array_push($data_photo, $data);
            }

            $product->photos()->saveMany($data_photo);
        }

        /*ATTRIBUTE PROCESS*/
        $attribute_arr = $request->input('attribute');
        $value_arr = $request->input('att_value');

        if(count($attribute_arr)){
            foreach($attribute_arr as $item_attribute) {
                if ($item_attribute) {
                    if (count($value_arr[$item_attribute])) {
                        foreach ($value_arr[$item_attribute] as $item_value) {
                            if ($item_value) {
                                $arr_obj_value[$item_attribute][] = new \App\Models\AttributeValue([
                                    'value' => $item_value,
                                    'product_id' => $product->id,
                                ]);
                            }
                        }

                    }
                    $arr_attribute_id [] = $item_attribute;
                }
            }
            if(!$product->attributes->isEmpty()){
                foreach($product->attributes as $item_attr){
                    $item_attr->attribute_values()->where('product_id',$product->id)->delete();
                }
            }

            if(count($arr_attribute_id)){
                $product->attributes()->sync($arr_attribute_id);
            }
            if(count($arr_obj_value)){
                foreach($arr_obj_value as $key => $att_val){
                    $att = $attribute->find($key);
                    $att->attribute_values()->saveMany($att_val);
                }
            }
        }

        return redirect()->route('admin.product.index')->with('success', 'Updated !');
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
            $id = $request->input('key');
            $this->photo->delete($id);
            return response()->json(['success'],200);
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
                'name' => $request->input('att_name'),
                'slug' => \LP_lib::unicode($request->input('att_name')),
                'description' => $request->input('att_description'),
            ];
            $item_attr = $attribute->create($data);
            $data_name = $item_attr->name;
            $data_id = $item_attr->id;
            return response()->json(['rs'=>'ok', 'data_name' => $data_name, 'data_id' => $data_id], 200);
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
            $att_price = $request->input('price');
            $order = $attvalue->getOrder();
            $data = [
                'value' => $att_value,
                'order' => $order,
                'attribute_id' => $att_id,
                'value_price' => $att_price,
            ];
            $item_value = $attvalue->create($data);
            $item_attr = $att->find($att_id);
            $array_value = [];
            $view = view('Admin::ajax.attribute.att_value', compact('item_value', 'item_attr', 'array_value'))->render();
            return response()->json(['error'=>false, 'data' => $view ]);
        }
    }

    /*REMOVE ATTRIBUTE OR VALUE*/
    public function removeAttribute(Request $request, AttributeRepository $att, AttributeValueRepository $attribute_value )
    {
        if(!$request->ajax()){
            abort('404');
        }else{
            $product_id = $request->input('product_id');
            $product = $this->productRepo->find($product_id);
            $product->attributes()->detach();
            $attribute_value->query()->where('product_id',$product_id)->delete();
            return response()->json(['error'=>false,'data'=>'done']);
        }
    }

    /*VALIDATE NEW ATTRIBUTE*/
    public function checkRuleAttribute(Request $request, AttributeValueRepository $attribute_value)
    {
        $request->merge(['att_name' => \LP_lib::unicode($request->input('att_name'))]);
        $rule = [
            'att_name' => 'required|unique:attributes,slug'
        ];
        $message = [
          'att_name.exists' => 'Thuộc tính đã tồn tại',
        ];
        $valid = \Validator::make($request->all(), $rule, $message);
        if($valid->fails()){
            return response()->json(false);
        }else{
            return response()->json(true);
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
            return response()->json(['error'=>false, 'mes' => 'Giá trị đã được xóa'], 200);
        }
    }

    /*CHECK UNIQUE PRODUCT*/
    public function checkUniqueProduct(Request $request)
    {
        $request->merge(['name' => \LP_lib::unicode($request->input('name'))]);
        $rule = [
          'name' => 'unique:products,slug'
        ];
        $valid = \Validator::make($request->all(), $rule);
        if($valid->fails()){
            return response()->json(false);
        }else{
            return response()->json(true);
        }

    }
}
