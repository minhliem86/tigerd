<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use App\Repositories\AgencyRepository;
use App\Repositories\Eloquent\CommonRepository;
use Datatables;
use DB;
use Validator;

class CategoryController extends Controller
{
    protected $cateRepo;
    protected $agency;
    protected $common;
    protected $_replacePath;

    public function __construct(CategoryRepository $cate, CommonRepository $common, AgencyRepository $agency)
    {
        $this->cateRepo = $cate;
        $this->agency = $agency;
        $this->common = $common;
        $this->_replacePath = env('REPLACE_PATH_UPLOAD') ? env('REPLACE_PATH_UPLOAD') : '';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin::pages.category.index');
    }

    public function getData(Request $request)
    {
        $cate = $this->cateRepo->query(['categories.id as id', 'categories.name as name', 'categories.sku_cate as sku_cate', 'categories.img_url as img_url', 'categories.order as order', 'categories.status as status', 'agencies.name as agency_name'])->join('agencies', 'agencies.id', '=', 'categories.agency_id');
            return Datatables::of($cate)
            ->addColumn('action', function($cate){
                return '<a href="'.route('admin.category.edit', $cate->id).'" class="btn btn-info btn-xs inline-block-span"> Edit </a>
                <form method="POST" action=" '.route('admin.category.destroy', $cate->id).' " accept-charset="UTF-8" class="inline-block-span">
                    <input name="_method" type="hidden" value="DELETE">
                    <input name="_token" type="hidden" value="'.csrf_token().'">
                               <button class="btn  btn-danger btn-xs remove-btn" type="button" attrid=" '.route('admin.category.destroy', $cate->id).' " onclick="confirm_remove(this);" > Remove </button>
               </form>' ;
           })->editColumn('order', function($cate){
               return "<input type='text' name='order' class='form-control' data-id= '".$cate->id."' value= '".$cate->order."' />";
           })->editColumn('status', function($cate){
               $status = $cate->status ? 'checked' : '';
               $cate_id =$cate->id;
               return '
                 <label class="toggle">
                    <input type="checkbox" name="status" value="1" '.$status.'   data-id ="'.$cate_id.'">
                    <span class="handle"></span>
                  </label>
              ';
           })->editColumn('img_url',function($cate){
             return '<img src="'.asset($cate->img_url).'" width="100" class="img-responsive">';
         })->filter(function($query) use ($request){
                    if (request()->has('name')) {
                        $query->where('categories.name', 'like', "%{$request->input('name')}%")->orWhere('categories.sku_cate','like', "%{$request->input('name')}%");
                    }
                })->setRowId('id')->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!$this->agency->query()->count()){
            return redirect()->route('admin.agency.index')->with('error','Vui lòng Tạo nhà cung cấp');
        }
        $agency = $this->agency->query(['name','id'])->lists('name', 'id')->toArray();
        return view('Admin::pages.category.create', compact('agency'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = Validator::make($request->all(),[
            'sku_cate' => 'required|min:2|max:3',
            'agency_id' => 'required'
        ],[
            'sku_cate.required' => 'Vui lòng điền SKU',
            'sku_cate.min' => 'SKU chỉ được từ 2-3 ký tự hoa',
            'sku_cate.max' => 'SKU chỉ được từ 2-3 ký tự hoa',
            'agency_id.required' => 'Vui lòng chọn Nhà Cung Cấp'
        ]);
        if($valid->fails()){
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }
        if($request->has('img_url')){
            $img_url = $this->common->getPath($request->input('img_url'),$this->_replacePath);
        }else{
            $img_url = '';
        }
        $order = $this->cateRepo->getOrder();

        $data = [
            'name' => $request->input('name'),
            'slug' => \LP_lib::unicode($request->input('name')),
            'description' => $request->input('description'),
            'sku_cate' => \Str::upper($request->input('sku_cate')),
            'agency_id' => $request->input('agency_id'),
            'img_url' => $img_url,
            'order' => $order,
        ];
        $this->cateRepo->create($data);
        return redirect()->route('admin.category.index')->with('success','Created !');
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
        $agency = $this->agency->query(['name','id'])->lists('name', 'id')->toArray();
        $inst = $this->cateRepo->find($id);
        return view('Admin::pages.category.edit', compact('inst','agency'));
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
        $valid = Validator::make($request->all(),[
            'sku_cate' => 'required|min:2|max:3',
            'agency_id' => 'required'
        ],[
            'sku_cate.required' => 'Vui lòng điền SKU',
            'sku_cate.min' => 'SKU chỉ được từ 2-3 ký tự hoa',
            'sku_cate.max' => 'SKU chỉ được từ 2-3 ký tự hoa',
            'agency_id.required' => 'Vui lòng chọn Nhà Cung Cấp'
        ]);
        if($valid->fails()){
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }

        $img_url = $this->common->getPath($request->input('img_url'),$this->_replacePath);

        $data = [
            'name' => $request->input('name'),
            'slug' => \LP_lib::unicode($request->input('name')),
            'description' => $request->input('description'),
            'sku_cate' => \Str::upper($request->input('sku_cate')),
            'agency_id' => $request->input('agency_id'),
            'img_url' => $img_url,
            'order' => $request->input('order'),
            'status' => $request->input('status'),
        ];
        $this->cateRepo->update($data, $id);

        return redirect()->route('admin.category.index')->with('success', 'Updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->cateRepo->delete($id);
        return redirect()->route('admin.category.index')->with('success','Deleted !');
    }

    /*DELETE ALL*/
    public function deleteAll(Request $request)
    {
      if(!$request->ajax()){
          abort(404);
      }else{
           $data = $request->arr;
           $response = $this->cateRepo->deleteAll($data);
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
                $obj = $this->cateRepo->find($k);
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
            $cate = $this->cateRepo->find($id);
            $cate->status = $value;
            $cate->save();
            return response()->json([
                'mes' => 'Updated',
                'error'=> false,
            ], 200);
        }
    }
}
