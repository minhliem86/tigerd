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
        'sku_product' => 'required|unique:products',
        'price' => 'required',
        'stock' => 'required'
    ];

    public $messages = [
        'category_id.required' => 'Vui lòng chọn Danh Mục Sản Phẩm',
        'sku_product.required' => 'Vui lòng nhập Mã Sản Phẩm',
        'sku_product.unique' => 'Mã Sản Phẩm này đã tồn tại',
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
        return view('Admin::pages.product.index');
    }

    public function getData(Request $request, AttributeRepository $attribute)
    {
        $product = $this->productRepo->query(['products.id as id', 'products.name as name', 'products.sku_product as sku_product', 'products.price as price', 'products.stock as quality', 'products.img_url as img_url', 'products.hot as hot', 'products.order as order', 'products.status as status', 'categories.name as cate_name', 'products.type as type'])->join('categories', 'categories.id', '=', 'products.category_id')->orderBy('id', 'ASC')->where('visibility', 1)->with(['values']);

        return Datatables::of($product)
            ->addColumn('action', function($product){
                $link = $product->type == 'simple' ?  '<a href="'.route('admin.product.edit', $product->id).'" class="btn btn-info btn-xs inline-block-span"> Edit </a>' : '<a href="'.route('admin.product.configuable.index', $product->id).'" class="btn btn-info btn-xs inline-block-span"> Edit </a>';

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
            ->addColumn('attribute', function($product) use ($attribute){
                $array_att = [];
                foreach($product->values as $item_value){
                    $array_att[$item_value->attributes->name][$item_value->id] = $item_value->value;
                }
                $string = '';

                foreach ($array_att as $k => $v){
                    $string .= '<p>'.$k.':';
                    foreach ($v as $item_v){
                        if($item_v == end($v)){
                            $string .= ' '.$item_v.'</p>';
                        }else{
                            $string .= ' '.$item_v.',';
                        }
                    }
                }
                return $string;
            })

            ->editColumn('price', function($product){
                $price = number_format($product->price);
                return $price;
            })
            ->editColumn('img_url',function($product){
                return '<img src="'.asset($product->img_url).'" width="80" class="img-responsive">';
            })
            ->filter(function($query) use ($request){
                if (request()->has('name')) {
                    $query->where('products.name', 'like', "%{$request->input('name')}%")->orWhere('products.sku_product', 'like', "%{$request->input('name')}%");
                }
            })->setRowId('id')->make(true);
    }

    /*TAO SIMPLE OR CONFIGUABLE*/
    public function getPreCreateProduct()
    {
        return view('Admin::pages.product.pre_create');
    }


    /*TAO SIMPLE OR CONFIGUABLE*/
    public function postPreCreateProduct(Request $request, CategoryRepository $cate)
    {
        $valid = Validator::make($request->all(), ['type' => 'required'], ['type.required' => 'Vui lòng chọn loại sản phẩm']);
        if($valid->fails()){
            return redirect()->back()->withInput()->withErrors($valid);
        }
        $type = $request->input('type');
        switch ($type){
            case 'simple' :
                return redirect()->route('admin.product.create');
                break;
            case 'configurable' :
                $cate = $cate->query(['id', 'name'])->lists('name','id')->toArray();
                return view('Admin::pages.product.attribute.create_configuable_s1', compact('cate'));
                break;
        }
    }


    /*TAO GENERAL SAN PHAM CONFIG*/
    public function postCreateConfiguableS1(Request $request)
    {
        $rule = [
            'category_id' => 'required',
            'name' => 'required',
            'sku_product' => 'unique:products'
        ];
        $mes = [
            'category_id.required' => 'Vui lòng chọn Danh Mục',
            'name.required' => 'Vui lòng nhập tên sản phẩm',
            'sku_product.unique' => 'Mã Sản Phẩm đã tồn tại',
        ];

        $valid = Validator::make($request->all(), $rule, $mes);
        if($valid->fails()){
            return redirect()->back()->withInput()->withErrors($valid);
        }
        if($request->has('img_url')){
            $img_url = $this->common->getPath($request->input('img_url'), $this->_replacePath);
        }else{
            $img_url = "";
        }
        $order = $this->productRepo->getOrder();
        $data = [
            'category_id' => $request->input('category_id'),
            'name' => $request->input('name'),
            'slug' => \LP_lib::unicode($request->input('name')),
            'sku_product' => $request->input('sku_product'),
            'description' => $request->input('description'),
            'img_url' => $img_url,
            'type' => 'configuable',
            'order' => $order,
            'visibility' => 1
        ];
        $parent_product = $this->productRepo->create($data);

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
            $parent_product->meta_configs()->save(new \App\Models\MetaConfiguration($data));
        }

        $parent_product_id = $parent_product->id;

        \Session::put('product_parent_id', $parent_product_id);
        return redirect()->route('admin.create.product.getAttribute');
    }


    /*ADD ATTRIBUTE TO PRODUCT*/
    public function getAttributeForProduct(Request $request, AttributeRepository $attribute)
    {
        $attribute = $attribute->all(['id', 'name', 'slug']);
        if($attribute->isEmpty()){
            return redirect()->route('admin.attribute.create')->with('url',$request->url());
        }
        return view('Admin::pages.product.attribute.getAttribute', compact('attribute'));
    }

    /*ADD ATTRIBUTE TO PRODUCT*/
    public function postAttributeForProduct(Request $request, AttributeRepository $attribute)
    {
        if(!$request->has('att_choose')){
            return redirect()->route('admin.product.create');
        }
        $arr_att = [];
        foreach($request->input('att_choose') as $item_att){
            $arr_att[] = $item_att;
        }
        $att = $attribute->findWhereIn('id',$arr_att,['id', 'name']);
        \Session::put('att', $att);
        return redirect()->route('admin.create.product.configuable.s2');
    }

    /*TAO SAN PHAM CON CHI TIET*/
    public function getCreateProductConfigS2()
    {
        if(!\Session::has('att')){
            return redirect()->route('admin.create.product.getAttribute');
        }
        $att = \Session::get('att');
        return view('Admin::pages.product.attribute.create_configuable_s2', compact('att'));
    }

    /*TAO SAN PHAM CON CHI TIET*/
    public function postCreateProductConfigS2(Request $request, AttributeValueRepository $attribute_value)
    {
        $rule = [
            'name' => 'required',
            'sku_product' => 'unique:products',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'value' => 'required'
        ];
        $mes = [
            'name.required' => 'Vui lòng nhập tên sản phẩm',
            'sku_product.unique' => 'Mã Sản Phẩm đã tồn tại',
            'price.required' => 'Vui lòng nhập giá',
            'price.numeric' => 'Giá là dạng số',
            'stock.required' => 'Vui lòng nhập số lượng trong kho',
            'stock.numeric' => 'Số lượng là dạng số',
            'value.required' => 'Vui lòng nhập giá trị thuộc tính',
        ];

        $valid = Validator::make($request->all(),$rule, $mes);
        if($valid->fails()){
            return redirect()->back()->withInput()->withErrors($valid);
        }
        if($request->has('img_url')){
            $img_url = $this->common->getPath($request->input('img_url'), $this->_replacePath);
        }else{
            $img_url = "";
        }
        $order = $this->productRepo->getOrder();
        $product_parent = $this->productRepo->find($request->product_parent_id);
        $data = [
            'name' => $request->name,
            'slug'=> \LP_lib::unicode($request->name),
            'sku_product'=> $request->sku_product,
            'description' => $request->description,
            'content'=> $request->content,
            'price' => $request->price,
            'discount' => $request->discount,
            'stock' => $request->stock,
            'img_url' => $img_url,
            'order'=>$order,
            'type' => $request->type,
            'visibility' => $request->visibility,
            'category_id' => $product_parent->category_id,
        ];
        $product = $this->productRepo->create($data);

        foreach($request->att as $k=>$item_att){
            $value = $attribute_value->create(['value' => $request->value[$k], 'attribute_id'=>$item_att]);
            $product->values()->attach($value->id);
        }

        $data_link = [
            'product_id' => $request->product_parent_id,
            'link_to_product_id' => $product->id
        ];
        \App\Models\ProductLink::create($data_link);

        return redirect()->route('admin.product.configuable.index',$request->product_parent_id);
        Session::forget('product_parent_id');
        Session::forget('att');

    }

    /*QUAN LY LIST SAN PHAM CONFIG*/
    public function getIndexProductConfig($parent_product_id)
    {
        $parent_product = $this->productRepo->find($parent_product_id);
        if($parent_product->type == 'configuable'){
            $array_product_link = [];
            if(!$parent_product->product_links->isEmpty()){
                foreach($parent_product->product_links as $item_link){
                    array_push($array_product_link, $item_link->link_to_product_id);
                }
            }
            $product_child = $this->productRepo->findWhereIn('id' , $array_product_link);
            return view('Admin::pages.product.configuable.index', compact('product_child', 'parent_product'));
        }else{
            return redirect()->back()->with('error','Sản Phẩm này không thuộc dạng phức hợp');
        }
    }

    /*TAO THEM SAN PHAM CON*/
    public function getCreateProductConfig($parent_product_id)
    {
        $parent_product = $this->productRepo->find($parent_product_id);

        Session::put('product_parent_id', $parent_product->id);
        return redirect()->route('admin.create.product.getAttribute');
    }

    /*EDIT SAM PHAM CON*/
    public function getEditProductConfig($id, $parent_product_id)
    {
        $parent_product = $this->productRepo->find($parent_product_id);
        $product = $this->productRepo->find($id);

        return view('Admin::pages.product.configuable.edit', compact('parent_product','product'));
    }

    /*EDIT SAM PHAM CON*/
    public function postEditProductConfig(Request $request, $id, AttributeValueRepository $value)
    {
        $rule = [
            'name' => 'required',
            'sku_product' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'value.*' => 'required'
        ];
        $mes = [
            'name.required' => 'Vui lòng nhập tên sản phẩm',
            'price.required' => 'Vui lòng nhập giá',
            'price.numeric' => 'Giá là dạng số',
            'stock.required' => 'Vui lòng nhập số lượng trong kho',
            'stock.numeric' => 'Số lượng là dạng số',
            'value.*.required' => 'Vui lòng nhập giá trị thuộc tính',
        ];
        $valid = Validator::make($request->all(),$rule, $mes);
        if($valid->fails()){
            return redirect()->back()->withErrors($valid->errors());
        }
        $img_url = $this->common->getPath($request->input('img_url'), $this->_replacePath);
        $data = [
            'name' => $request->name,
            'slug'=> \LP_lib::unicode($request->name),
            'sku_product'=> $request->sku_product,
            'description' => $request->description,
            'content'=> $request->content,
            'price' => $request->price,
            'discount' => $request->discount,
            'stock' => $request->stock,
            'img_url' => $img_url,
        ];
        $this->productRepo->update($data, $id);
        foreach($request->value as $k=>$item_att){
            $value = $value->find($request->value_id[$k]);
            $value->value = $item_att;
            $value->save();
        }
        return redirect()->route('admin.product.configuable.index',$request->product_parent_id)->with('success', 'Cập nhật thành công');
    }

    /*REMOVE SAN PHAM*/
    public function postRemoveConfiguable($id)
    {
        $this->productRepo->delete($id);
        return redirect()->back()->with('success', 'Sản Phẩm thuộc tính đã xóa.');
    }

    /*AJAX CHANGE DEFAULT*/
    public function postChangeDefault(Request $request)
    {
        if(!$request->ajax()){
            abort(404);
        }else{
            $id = $request->input('id');
            $parent_id = $request->input('parent_id');
            $parent_product = $this->productRepo->find($parent_id);
            $array_child_id = [];
            foreach($parent_product->product_links as $item_link)
            {
                array_push($array_child_id, $item_link->link_to_product_id);
            }
            $collect_product_child = $this->productRepo->query()->whereIn('id', $array_child_id);
            $collect_product_child->update(['default'=>0]);
            $data = [
                'default' => 1
            ];
            $this->productRepo->update($data, $id);
            return response()->json(['error', false, 'data' => $this->productRepo->find($id)->name]);
        }
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
        $array_att = [];
        $array_value = [];
        return view('Admin::pages.product.create', compact('cate', 'attribute_list', 'array_value', 'array_att'));
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

        $sku_product = \Str::upper(trim($request->input('sku_product')));
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
        if($request->has('img_detail')){
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
    public function edit($id, CategoryRepository $cate, AttributeRepository $attribute)
    {
        $attribute_list = $attribute->all(['id', 'name', 'slug']);
        $cate = $cate->query(['id','name'])->lists('name', 'id')->toArray();
        $inst = $this->productRepo->find($id,['*'],['photos','attributes','values']);
        $array_att = [];
        $array_value = [];
        foreach($inst->attributes as $item_att){
            array_push($array_att,$item_att->id);
        };
        foreach($inst->values as $item_value){
            array_push($array_value,$item_value->id);
        };
        return view('Admin::pages.product.edit', compact('inst', 'cate', 'attribute_list', 'array_att', 'array_value'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  CategoryRepository $cate, MetaRepository $meta,  $id)
    {
        $valid = Validator::make($request->all(), $this->rules_edit, $this->messages_edit);
        if($valid->fails()){
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }
        $img_url = $this->common->getPath($request->input('img_url'), $this->_replacePath);

        $order = $this->productRepo->getOrder();
        $data = [
            'name' => $request->input('name'),
            'slug' => \LP_lib::unicode($request->input('name')),
            'description' => $request->input('description'),
            'content' => $request->input('content'),
            'price' => $request->input('price'),
            'discount' => $request->input('discount'),
            'sku_product' => $request->input('sku_product'),
            'stock' => $request->input('stock'),
            'img_url' => $img_url,
            'order' => $request->input('order'),
            'status' => $request->input('status'),
            'category_id' => $request->input('category_id'),
        ];

        $product = $this->productRepo->update($data, $id);

        if($request->has('meta_config')){
            $meta_img = $this->common->getPath($request->input('meta_img'), $this->_replacePath);
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

        if($request->has('img_detail')){
            $data_photo = [];
            if($request->hasFile('thumb-input')){
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
        }

        if($request->has('attribute_section')){
            if($request->has('att')){
                $data_att = $request->input('att');
                $product->attributes()->sync($data_att);
                if($request->has('att_value')){
                    $data_value = $request->input('att_value');
                    $product->values()->sync($data_value);
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
            $item_attr = $attribute->create($data);
            $attribute_list = $attribute->all(['id','name','slug'],['attribute_values']);
            $array_att = [];
            $view = view('Admin::ajax.attribute.att', compact('item_attr', 'array_att'))->render();

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
//            $view = view('Admin::ajax.attribute.attribute_value', compact('item_attr', 'array_att', 'array_value'))->render();
            $view = view('Admin::ajax.attribute.att_value', compact('item_value', 'item_attr', 'array_value'))->render();
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
                return response()->json(['error'=>false, 'mes' => 'Thuộc tính đã được xóa thành công'], 200);
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
            return response()->json(['error'=>false, 'mes' => 'Giá trị đã được xóa'], 200);
        }
    }
}
