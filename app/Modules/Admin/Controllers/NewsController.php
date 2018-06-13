<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\NewsRepository;
use App\Repositories\NewsTypeRepository;
use Yajra\Datatables\Datatables;
use App\Repositories\Eloquent\CommonRepository;
use App\Repositories\MetaRepository;

class NewsController extends Controller
{
    protected $news;
    protected $newstype;
    protected $common;
    protected $_replacePath;

    public function __construct(NewsRepository $news, CommonRepository $common, NewsTypeRepository $newstype)
    {
        $this->news = $news;
        $this->newstype = $newstype;
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
        $news_quality = $this->news->all(['id'])->count();
        return view('Admin::pages.news.index', compact('news_quality', 'newstype_list'));
    }

    public function getData(Request $request)
    {
        $data = $this->news->query(['news.id as id', 'news.img_url as img_url', 'news.name as name' ,'news.order as order', 'news.status as status', 'news_type.title as title'])->join('news_type', 'news.news_type_id','=','news_type.id');
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
                return '<a href="'.route('admin.news.edit', $data->id).'" class="btn btn-info btn-xs inline-block-span"> Edit </a>
                <form method="POST" action=" '.route('admin.news.destroy', $data->id).' " accept-charset="UTF-8" class="inline-block-span">
                    <input name="_method" type="hidden" value="DELETE">
                    <input name="_token" type="hidden" value="'.csrf_token().'">
                               <button class="btn  btn-danger btn-xs remove-btn" type="button" attrid=" '.route('admin.news.destroy', $data->id).' " onclick="confirm_remove(this);" > Remove </button>
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
        $newstype_list = $this->newstype->query(['*'])->lists('title','id')->toArray();
        return view('Admin::pages.news.create', compact('newstype_list'));
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
        $order = $this->news->getOrder();
        $data = [
            'name' => $request->input('name'),
            'slug' => \LP_lib::unicode($request->input('name')),
            'description' => $request->input('description'),
            'content' => $request->input('content'),
            'img_url' => $img_url,
            'order' => $order,
            'news_type_id' => $request->input('news_type_id'),
        ];

        $news = $this->news->create($data);

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
            $news->meta_configs()->save(new \App\Models\MetaConfiguration($data_seo));
        }
        return redirect()->route('admin.news.index')->with('success','Created !');
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
        $inst = $this->news->find($id);
        $newstype_list = $this->newstype->query(['*'])->lists('title','id')->toArray();
        return view('Admin::pages.news.edit', compact('inst','newstype_list'));
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
            'name' => $request->input('name'),
            'slug' => \LP_lib::unicode($request->input('name')),
            'description' => $request->input('description'),
            'content' => $request->input('content'),
            'img_url' => $img_url,
            'order' => $request->input('order'),
            'status' => $request->input('status'),
            'news_type_id' => $request->input('news_type_id'),
        ];

        $news = $this->news->update($data, $id);

        if($request->has('meta_config')){
            $meta_img = $this->common->getPath($request->input('meta_img'),$this->_replacePath);
            $data_seo = [
                'meta_keywords' => $request->input('meta_keywords'),
                'meta_description' => $request->input('meta_description'),
                'meta_img' => $meta_img,
            ];
            if(!$request->has('meta_config_id')){
                $news->meta_configs()->save(new \App\Models\MetaConfiguration($data_seo));
            }
            $meta_config = $meta->update($data_seo,$request->input('meta_config_id'));
        }

        return redirect()->route('admin.news.index')->with('success', 'Updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        $this->news->find($id)->meta_configs()->delete();
        $this->news->delete($id);
        return redirect()->route('admin.news.index')->with('success','Deleted !');
    }

    /*DELETE ALL*/
    public function deleteAll(Request $request)
    {
        if(!$request->ajax()){
            abort(404);
        }else{
            $data = $request->arr;
            $response = $this->news->deleteAll($data);
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
                $obj = $this->news->find($k);
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
            $cate = $this->news->find($id);
            $cate->status = $value;
            $cate->save();
            return response()->json([
                'mes' => 'Updated',
                'error'=> false,
            ], 200);
        }
    }
}
