<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\PromotionRepository;
use Yajra\Datatables\Datatables;
use App\Repositories\Eloquent\CommonRepository;
use Carbon\Carbon;

class PromotionController extends Controller
{
    protected $promotion;
    protected $common;
    protected $_replacePath;

    public function __construct(PromotionRepository $promotion, CommonRepository $common)
    {
        $this->promotion = $promotion;
        $this->common = $common;
        $this->_replacePath = env('REPLACE_PATH_UPLOAD') ? env('REPLACE_PATH_UPLOAD') : '';
        $this->checkPromotionExpire();
    }

    public function checkPromotionExpire(){
        $rs = $this->promotion->query()->where('to_time','<', Carbon::now()->toDateString())->get();
        foreach($rs as $item)
        {
            $item->status = 0;
            $item->update();
        }
    }

    protected $rule = [
        'sku_promotion' => 'required|min:3|max:10',
        'value' => 'required|integer',
        'quantity' => 'required|integer',
        'from_time' => 'required',
        'to_time' => 'required',
    ];

    protected $message = [
        'sku_promotion.required' => 'Vui lòng nhập Mã Khuyến Mãi',
        'sku_promotion.min' => 'Mã Khuyến Mãi phải có ít nhất 3 ký tự',
        'sku_promotion.max' => 'Mã Khuyến Mãi phải có nhiều nhất 10 ký tự',
        'value.required' => 'Vui lòng nhập Giá Trị',
        'value.integer' => 'Giá trị là dạng số',
        'quantity.required' => 'Vui lòng nhập Số Lượng Mã',
        'quantity.integer' => 'Số Lượng Mã là dạng số',
        'from_time.required' => 'Vui lòng nhập Ngày bắt đầu',
        'to_time.required' => 'Vui lòng nhập Ngày kết thúc',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promotion_active = $this->promotion->query(['id','status'])->where('status',1)->where('quantity','>',0)->count();
        $promotion_deactive = $this->promotion->query(['id','status'])->where('status',0)->where('quantity','<=',0)->count();
        return view('Admin::pages.promotion.index', compact('promotion_active', 'promotion_deactive'));
    }

    public function getData(Request $request)
    {
        $data = $this->promotion->query(['id', 'name', 'sku_promotion', 'num_use' ,'quantity', 'value', 'status', 'to_time', 'value_type']);
        $datatable = Datatables::of($data)
            ->editColumn('quantity', function($data){
                $quantity = $data->quantity - $data->num_use;
                return $quantity;
            })
            ->editColumn('to_time', function($data){
                return \Carbon\Carbon::parse($data->to_time)->format('d/m/Y');
            })
            ->editColumn('value', function($data){
                return number_format($data->value).' '.$data->value_type;
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
                return '<a href="'.route('admin.promotion.edit', $data->id).'" class="btn btn-info btn-xs inline-block-span"> Edit </a>
                <form method="POST" action=" '.route('admin.promotion.destroy', $data->id).' " accept-charset="UTF-8" class="inline-block-span">
                    <input name="_method" type="hidden" value="DELETE">
                    <input name="_token" type="hidden" value="'.csrf_token().'">
                               <button class="btn  btn-danger btn-xs remove-btn" type="button" attrid=" '.route('admin.promotion.destroy', $data->id).' " onclick="confirm_remove(this);" > Remove </button>
               </form>' ;
            })
            ->filter(function($query) use ($request){
                if (request()->has('name')) {
                    $query->where('name', 'like', "%{$request->input('name')}%")->orWhere('sku_promotion', 'like', "%{$request->input('name')}%");
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
        return view('Admin::pages.promotion.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = \Validator::make($request->all(), $this->rule, $this->message);
        if($valid->fails()){
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }
        $order = $this->promotion->getOrder();
        if($request->input('value_type') == '%'){
            $value = trim(\Str::lower($request->input('value'))).$request->input('value_type');
        }else{
            $value = trim(\Str::lower($request->input('value')));
        }
        $from_time = Carbon::createFromFormat('d-m-Y', $request->input('from_time'))->format('Y-m-d');
        $to_time = Carbon::createFromFormat('d-m-Y', $request->input('to_time'))->format('Y-m-d');

        $data = [
            'name' => $request->input('name'),
            'slug' => \LP_lib::unicode($request->input('name')),
            'sku_promotion' => \Str::upper(trim($request->input('sku_promotion'))),
            'description' => $request->input('description'),
            'type' => $request->input('type'),
            'target' => $request->input('target'),
            'value' => $value,
            'value_type' => $request->input('value_type'),
            'quantity' => $request->input('quantity'),
            'from_time' => $from_time,
            'to_time' => $to_time,
        ];
        
        $promotion = $this->promotion->create($data);

        return redirect()->route('admin.promotion.index')->with('success','Created !');
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
        $inst = $this->promotion->find($id);
        return view('Admin::pages.promotion.edit', compact('inst'));
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
        $valid = \Validator::make($request->all(), $this->rule, $this->message);
        if($valid->fails()){
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }
        if($request->input('value_type') === '%'){
            $value = trim(\Str::lower($request->input('value'))).$request->input('value_type');
        }else{
            $value = trim(\Str::lower($request->input('value')));
        }
        $from_time = Carbon::createFromFormat('d-m-Y', $request->input('from_time'))->format('Y-m-d');
        $to_time = Carbon::createFromFormat('d-m-Y', $request->input('to_time'))->format('Y-m-d');

        $data = [
            'name' => $request->input('name'),
            'slug' => \LP_lib::unicode($request->input('name')),
            'sku_promotion' => \Str::upper(trim($request->input('sku_promotion'))),
            'description' => $request->input('description'),
            'type' => $request->input('type'),
            'target' => $request->input('target'),
            'value' => $value,
            'value_type' => $request->input('value_type'),
            'quantity' => $request->input('quantity'),
            'from_time' => $from_time,
            'to_time' => $to_time,
            'status' => $request->input('status'),
        ];

        $promotion = $this->promotion->update($data, $id);

        return redirect()->route('admin.promotion.index')->with('success', 'Updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->promotion->delete($id);
        return redirect()->route('admin.promotion.index')->with('success','Deleted !');
    }

    /*DELETE ALL*/
    public function deleteAll(Request $request)
    {
        if(!$request->ajax()){
            abort(404);
        }else{
            $data = $request->arr;
            $response = $this->promotion->deleteAll($data);
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
                $obj = $this->promotion->find($k);
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
            $cate = $this->promotion->find($id);
            $cate->status = $value;
            $cate->save();
            return response()->json([
                'mes' => 'Updated',
                'error'=> false,
            ], 200);
        }
    }
}
