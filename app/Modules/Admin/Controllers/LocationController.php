<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use DB;

class LocationController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCity(Request $request)
    {
        if($request->ajax()){
            $city = DB::table('cities')->orderBy('order','DESC')->select('name','id','order');

            $datatable = Datatables::of($city)
                ->editColumn('order', function($city){
                    return "<input type='text' name='order' class='form-control' data-id= '".$city->id."' value= '".$city->order."' />";
                })
                ->filter(function($query) use ($request){
                    if (request()->has('name')) {
                        $query->where('name', 'like', "%{$request->input('name')}%");
                    }
                })
                ->make(true);
            return $datatable;
        }
        return view('Admin::pages.location.city');
    }

//    public function indexDistrict()
//    {
//        $list_city = DB::table('cities')->select('name','code')->lists('name','code')->toArray();
//        return view('Admin::pages.location.disctrict', compact('list_city'));
//    }

    public function getDistrict(Request $request)
    {
        if($request->ajax()){
            $district = DB::table('district')->orderBy('order','DESC')->select('name_with_type','id','order');
            $datatable = Datatables::of($district)
                ->editColumn('order', function($district){
                    return "<input type='text' name='order' class='form-control' data-id= '".$district->id."' value= '".$district->order."' />";
                })
                ->filter(function($query) use ($request){
                    if (request()->has('name')) {
                        $query->where('name', 'like', "%{$request->input('name')}%");
                    }
                    if($request->has('city_id')){
                        $query->where('parent_code',$request->input('city_id'));
                    }
                })
                ->make(true);
            return $datatable;
        }
        $list_city = DB::table('cities')->select('name_with_type','code')->orderBy('order','DESC')->lists('name_with_type','code');
        return view('Admin::pages.location.disctrict', compact('list_city'));
    }

    public function getWard(Request $request)
    {
        if($request->ajax()){
            $ward = DB::table('wards')->orderBy('order','DESC')->select('name_with_type','id','order');

            $datatable = Datatables::of($ward)
                ->editColumn('order', function($ward){
                    return "<input type='text' name='order' class='form-control' data-id= '".$ward->id."' value= '".$ward->order."' />";
                })
                ->filter(function($query) use ($request){
                    if (request()->has('name')) {
                        $query->where('name', 'like', "%{$request->input('name')}%");
                    }
                    if($request->has('district_code')){
                        $query->where('parent_code',$request->input('district_code'));
                    }
                })
                ->make(true);
            return $datatable;
        }
        $list_city = DB::table('cities')->select('name_with_type','code')->orderBy('order','DESC')->lists('name_with_type','code');
        return view('Admin::pages.location.ward', compact('list_city'));
    }

    /*UPDATE ORDER*/
    public function postAjaxUpdateOrder(Request $request)
    {
        if(!$request->ajax())
        {
            abort('404', 'Not Access');
        }else{
            $key = $request->input('key');
            $data = $request->input('data');
            switch ($key) {
                case 'city' :
                    foreach($data as $k => $v){
                        $upt  =  [
                            'order' => $v,
                        ];
                        DB::table('cities')->where('id',$k)->update($upt);
                    }
                    break;

                case 'district' :
                    foreach($data as $k => $v){
                        $upt  =  [
                            'order' => $v,
                        ];
                        DB::table('district')->where('id',$k)->update($upt);
                    }
                    break;

                default :
                    foreach($data as $k => $v){
                        $upt  =  [
                            'order' => $v,
                        ];
                        DB::table('wards')->where('id',$k)->update($upt);
                    }
                    break;
            }

            return response()->json(['msg' =>'ok', 'code'=>200], 200);
        }
    }

    public function getDistrictAjax(Request $request)
    {
        if(!$request->ajax()){
            abort(404);
        }else{
            $city_id = $request->input('city_code');
            $list_district = DB::table('district')->where('parent_code',$city_id)->orderBy('order','DESC')->lists('name_with_type','code');
            $view = view('Admin::ajax.ajaxGetDistrict', compact('list_district'))->render();
            return  response()->json(['data'=>$view]);
        }
    }
}
