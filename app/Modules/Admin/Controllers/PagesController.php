<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\PagesRepository;
use Yajra\Datatables\Datatables;
use App\Repositories\Eloquent\CommonRepository;
use App\Repositories\MetaRepository;

class PagesController extends Controller
{
    protected $pages;
    protected $common;
    protected $_replacePath;

    public function __construct(PagesRepository $pages, CommonRepository $common)
    {
        $this->pages = $pages;
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
        $pages_quality = $this->pages->all(['id'])->count();
        return view('Admin::pages.pages.index', compact('pages_quality'));
    }

    public function getData(Request $request)
    {
        $data = $this->pages->query(['id', 'name' ,'order', 'status']);
        $datatable = Datatables::of($data)
            ->editColumn('order', function($data){
                return "<input type='text' name='order' class='form-control' data-id= '".$data->id."' value= '".$data->order."' />";
            })
            ->editColumn('status', function($data){
                $status = $data->status ? 'checked' : '';
                $data_id =$data->id;
                return '
                 <label class="toggle">
                    <input type="checkbox" name="status" value="1" '.$status.'   data-id ="'.$data_id.'">
                    <span class="handle"></span>
                  </label>
              ';
            })
            ->addColumn('action', function($data){
                return '<a href="'.route('admin.pages.edit', $data->id).'" class="btn btn-info btn-xs inline-block-span"> Edit </a>
                <form method="POST" action=" '.route('admin.pages.destroy', $data->id).' " accept-charset="UTF-8" class="inline-block-span">
                    <input name="_method" type="hidden" value="DELETE">
                   
               </form>' ;
            })
            ->filter(function($query) use ($request){
                if (request()->has('name')) {
                    $query->where('name', 'like', "%{$request->input('name')}%");
                }
            })
            ->make(true);
        return $datatable;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin::pages.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = $this->pages->getOrder();
        $data = [
            'name' => $request->input('name'),
            'slug' => \LP_lib::unicode($request->input('name')),
            'description' => $request->input('description'),
            'order' => $order,
        ];
        
        $pages = $this->pages->create($data);

        if($request->has('meta_config')){
            if($request->has('meta_img')){
                $meta_img = $this->common->getPath($request->input('meta_img'),$this->_replacePath);
            }else{
                $meta_img = '';
            }
            $data_seo = [
                'meta_keywords' => $request->input('meta_keywords'),
                'meta_description' => $request->input('meta_description'),
                'meta_img' => $meta_img,
            ];
            $pages->meta_configs()->save(new \App\Models\MetaConfiguration($data_seo));
        }
        return redirect()->route('admin.pages.index')->with('success','Created !');
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
        $inst = $this->pages->find($id);
        return view('Admin::pages.pages.edit', compact('inst'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, MetaRepository $meta)
    {
        $data = [
            'name' => $request->input('name'),
            'slug' => \LP_lib::unicode($request->input('name')),
            'description' => $request->input('description'),
            'order' => $request->input('order'),
            'status' => $request->input('status'),
        ];

        $pages = $this->pages->update($data, $id);

        if($request->has('meta_config')){
            $meta_img = $this->common->getPath($request->input('meta_img'),$this->_replacePath);
            $data_seo = [
                'meta_keywords' => $request->input('meta_keywords'),
                'meta_description' => $request->input('meta_description'),
                'meta_img' => $meta_img,
            ];
            if(!$request->has('meta_config_id')){
                $pages->meta_configs()->save(new \App\Models\MetaConfiguration($data_seo));
            }
            $meta_config = $meta->update($data_seo,$request->input('meta_config_id'));
        }

        return redirect()->route('admin.pages.index')->with('success', 'Updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->pages->delete($id);
        return redirect()->route('admin.pages.index')->with('success','Deleted !');
    }

    /*DELETE ALL*/
    public function deleteAll(Request $request)
    {
        if(!$request->ajax()){
            abort(404);
        }else{
            $data = $request->arr;
            $response = $this->pages->deleteAll($data);
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
                $obj = $this->pages->find($k);
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
            $cate = $this->pages->find($id);
            $cate->status = $value;
            $cate->save();
            return response()->json([
                'mes' => 'Updated',
                'error'=> false,
            ], 200);
        }
    }
}
