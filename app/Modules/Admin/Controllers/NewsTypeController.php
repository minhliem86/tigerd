<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\NewsTypeRepository;
use App\Repositories\Eloquent\CommonRepository;
use Datatables;

class NewsTypeController extends Controller
{
    protected $newstype;
    protected $common;
    protected $_replacePath;

    public function __construct(NewsTypeRepository $newstype, CommonRepository $common)
    {
        $this->newstype = $newstype;
        $this->common = $common;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = $this->newstype->query(['id', 'img_url', 'title' ,'order', 'status']);
            $datatable = Datatables::of($data)
                ->editColumn('img_url', function ($data){
                    $img = "<img src='".asset('public/upload/'.$data->img_url)."' style='max-width:100px'/>";
                    return $img;
                })
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
                    return '<a href="'.route('admin.newstype.edit', $data->id).'" class="btn btn-info btn-xs inline-block-span"> Edit </a>
                <form method="POST" action=" '.route('admin.newstype.destroy', $data->id).' " accept-charset="UTF-8" class="inline-block-span">
                    <input name="_method" type="hidden" value="DELETE">
                    <input name="_token" type="hidden" value="'.csrf_token().'">
                               <button class="btn  btn-danger btn-xs remove-btn" type="button" attrid=" '.route('admin.newstype.destroy', $data->id).' " onclick="confirm_remove(this);" > Remove </button>
               </form>' ;
                })
                ->filter(function($query) use ($request){
                    if (request()->has('name')) {
                        $query->where('title', 'like', "%{$request->input('name')}%");
                    }
                })
                ->make(true);
            return $datatable;
        }
        return view('Admin::pages.newstype.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin::pages.newstype.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->has('img_url')){
            $img_url = $this->common->getPath($request->input('img_url'));
        }else{
            $img_url = '';
        }
        $order = $this->newstype->getOrder();
        $data = [
            'title' => $request->input('title'),
            'slug' => \LP_lib::unicode($request->input('title')),
            'img_url' => $img_url,
            'order' => $order,
        ];

        $newstype = $this->newstype->create($data);

        if($request->has('meta_config')){
            if($request->has('meta_img')){
                $meta_img = $this->common->getPath($request->input('meta_img'));
            }else{
                $meta_img = '';
            }
            $data_seo = [
                'meta_keywords' => $request->input('meta_keywords'),
                'meta_description' => $request->input('meta_description'),
                'meta_img' => $meta_img,
            ];
            $newstype->meta_configs()->save(new \App\Models\MetaConfiguration($data_seo));
        }
        return redirect()->route('admin.newstype.index')->with('success','Created !');
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
        $inst = $this->newstype->find($id);
        return view('Admin::pages.newstype.edit', compact('inst'));
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
        $img_url = $this->common->getPath($request->input('img_url'));
        $data = [
            'title' => $request->input('title'),
            'slug' => \LP_lib::unicode($request->input('title')),
            'img_url' => $img_url,
            'order' => $request->input('order'),
            'status' => $request->input('status'),
        ];

        $newstype = $this->newstype->update($data, $id);

        if($request->has('meta_config')){
            $meta_img = $this->common->getPath($request->input('meta_img'),$this->_replacePath);
            $data_seo = [
                'meta_keywords' => $request->input('meta_keywords'),
                'meta_description' => $request->input('meta_description'),
                'meta_img' => $meta_img,
            ];
            if(!$request->has('meta_config_id')){
                $newstype->meta_configs()->save(new \App\Models\MetaConfiguration($data_seo));
            }
            $meta_config = $meta->update($data_seo,$request->input('meta_config_id'));
        }

        return redirect()->route('admin.newstype.index')->with('success', 'Updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        $this->newstype->find($id)->meta_configs()->delete();
        $this->newstype->delete($id);
        return redirect()->route('admin.newstype.index')->with('success','Deleted !');
    }

    /*DELETE ALL*/
    public function deleteAll(Request $request)
    {
        if(!$request->ajax()){
            abort(404);
        }else{
            $data = $request->arr;
            $response = $this->newstype->deleteAll($data);
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
                $obj = $this->newstype->find($k);
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
            $cate = $this->newstype->find($id);
            $cate->status = $value;
            $cate->save();
            return response()->json([
                'mes' => 'Updated',
                'error'=> false,
            ], 200);
        }
    }
}
