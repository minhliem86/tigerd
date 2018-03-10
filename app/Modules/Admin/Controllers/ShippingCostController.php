<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\ShippingCostRepository;
use Yajra\Datatables\Datatables;
use App\Repositories\Eloquent\CommonRepository;

class ShippingCostController extends Controller
{
    protected $shippingcost;
    protected $common;

    public function __construct(ShippingCostRepository $shippingcost, CommonRepository $common)
    {
        $this->shippingcost = $shippingcost;
        $this->common = $common;
    }

    protected  function _validate()
    {
        return [
            'city_id' => 'required',
            'district_id' => 'required',
            'cost' => 'required'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin::pages.shippingcost.index');
    }

    public function getData(Request $request)
    {
        $data = $this->shippingcost->query(['shipping_costs.id', 'shipping_costs.cost' , 'district.name_with_type'])->join('district','district.code','=','shipping_costs.district_id');
        $datatable = Datatables::of($data)
            ->addColumn('action', function($data){
                return '<a href="'.route('admin.shippingcost.edit', $data->id).'" class="btn btn-info btn-xs inline-block-span"> Edit </a>
                <form method="POST" action=" '.route('admin.shippingcost.destroy', $data->id).' " accept-charset="UTF-8" class="inline-block-span">
                    <input name="_method" type="hidden" value="DELETE">
                    <input name="_token" type="hidden" value="'.csrf_token().'">
                               <button class="btn  btn-danger btn-xs remove-btn" type="button" attrid=" '.route('admin.shippingcost.destroy', $data->id).' " onclick="confirm_remove(this);" > Remove </button>
               </form>' ;
            })
            ->editColumn('cost', function($data){
                return number_format($data->cost). ' VND';
            })
            ->filter(function($query) use ($request){
                if (request()->has('name')) {
                    $query->where('district.name_with_type', 'like', "%{$request->input('name')}%");
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
        $city = \DB::table('cities')->lists('name', 'code');
        return view('Admin::pages.shippingcost.create', compact('city'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = \Validator::make($request->all(), $this->_validate());
        if($valid->fails()){
            return back()->withInput()->withErrors($valid->errors());
        }
        $data = [
            'cost' => $request->input('cost'),
            'district_id' => $request->input('district_id'),
        ];

        $shippingcost = $this->shippingcost->create($data);

        return redirect()->route('admin.shippingcost.index')->with('success','Created !');
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
        $inst = $this->shippingcost->find($id);
        return view('Admin::pages.shippingcost.edit', compact('inst'));
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
        $valid = \Validator::make($request->all(), $this->_validate());
        if($valid->fails()){
            return back()->withInput()->withErrors($valid->errors());
        }
        $data = [
            'name' => $request->input('name'),
            'slug' => \LP_lib::unicode($request->input('name')),
            'description' => $request->input('description'),
            'order' => $request->input('order'),
            'status' => $request->input('status'),
        ];

        $shippingcost = $this->shippingcost->update($data, $id);

        if($request->has('meta_config')){
            $meta_img = $this->common->getPath($request->input('meta_img'),$this->_replacePath);
            $data_seo = [
                'meta_keywords' => $request->input('meta_keywords'),
                'meta_description' => $request->input('meta_description'),
                'meta_img' => $meta_img,
            ];
            if(!$request->has('meta_config_id')){
                $shippingcost->meta_configs()->save(new \App\Models\MetaConfiguration($data_seo));
            }
            $meta_config = $meta->update($data_seo,$request->input('meta_config_id'));
        }

        return redirect()->route('admin.shippingcost.index')->with('success', 'Updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->shippingcost->delete($id);
        return redirect()->route('admin.shippingcost.index')->with('success','Deleted !');
    }

    /*DELETE ALL*/
    public function deleteAll(Request $request)
    {
        if(!$request->ajax()){
            abort(404);
        }else{
            $data = $request->arr;
            $response = $this->shippingcost->deleteAll($data);
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
                $obj = $this->shippingcost->find($k);
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
            $cate = $this->shippingcost->find($id);
            $cate->status = $value;
            $cate->save();
            return response()->json([
                'mes' => 'Updated',
                'error'=> false,
            ], 200);
        }
    }

    public function loadDistrict(Request $request)
    {
        if(!$request->ajax()){
            abort(404);
        }else{
            $district = \DB::table('district')->where('parent_code',$request->input('city_id'))->lists('name_with_type','code');
            $view = view('Admin::pages.shippingcost.loadDistrict', compact('district'))->render();
            return response()->json(['data'=>$view], 200);
        }
    }
}
