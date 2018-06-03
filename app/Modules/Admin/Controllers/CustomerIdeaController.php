<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\CustomerIdeaRepository;
use App\Repositories\Eloquent\CommonRepository;
use Datatables;

class CustomerIdeaController extends Controller
{
    protected $customerIdea;

    public function __construct(CustomerIdeaRepository $customerIdea, CommonRepository $common){
        $this->customerIdea = $customerIdea;
        $this->common = $common;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idea_quantity = $this->customerIdea->all(['id'])->count();
        return view('Admin::pages.customerIdea.index', compact('idea_quantity'));
    }

    public function getData(Request $request)
    {
        $data = $this->customerIdea->query(['id', 'img_url', 'customer_name' ,'order', 'status']);
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
                return '<a href="'.route('admin.customer-idea.edit', $data->id).'" class="btn btn-info btn-xs inline-block-span"> Edit </a>
                <form method="POST" action=" '.route('admin.customer-idea.destroy', $data->id).' " accept-charset="UTF-8" class="inline-block-span">
                    <input name="_method" type="hidden" value="DELETE">
                    <input name="_token" type="hidden" value="'.csrf_token().'">
                               <button class="btn  btn-danger btn-xs remove-btn" type="button" attrid=" '.route('admin.customer-idea.destroy', $data->id).' " onclick="confirm_remove(this);" > Remove </button>
               </form>' ;
            })
            ->filter(function($query) use ($request){
                if (request()->has('customer_name')) {
                    $query->where('customer_name', 'like', "%{$request->input('name')}%");
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
        return view('Admin::pages.customerIdea.create');
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
        $order = $this->customerIdea->getOrder();
        $data = [
            'customer_name' => $request->input('customer_name'),
            'slug' => \LP_lib::unicode($request->input('customer_name')),
            'content' => $request->input('content'),
            'img_url' => $img_url,
            'order' => $order,
        ];

        $this->customerIdea->create($data);
        return redirect()->route('admin.customer-idea.index')->with('success','Created !');
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
        $inst = $this->customerIdea->find($id);
        return view('Admin::pages.customerIdea.edit', compact('inst'));
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
        $img_url = $this->common->getPath($request->input('img_url'));
        $data = [
            'customer_name' => $request->input('customer_name'),
            'slug' => \LP_lib::unicode($request->input('customer_name')),
            'content' => $request->input('content'),
            'img_url' => $img_url,
            'order' => $request->input('order'),
            'status' => $request->input('status'),
        ];

        $this->customerIdea->update($data, $id);
        return redirect()->route('admin.customer-idea.index')->with('success', 'Updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->customerIdea->delete($id);
        return redirect()->route('admin.customer-idea.index')->with('success','Deleted !');
    }

    /*DELETE ALL*/
    public function deleteAll(Request $request)
    {
        if(!$request->ajax()){
            abort(404);
        }else{
            $data = $request->arr;
            $response = $this->customerIdea->deleteAll($data);
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
                $obj = $this->customerIdea->find($k);
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
            $cate = $this->customerIdea->find($id);
            $cate->status = $value;
            $cate->save();
            return response()->json([
                'mes' => 'Updated',
                'error'=> false,
            ], 200);
        }
    }
}
