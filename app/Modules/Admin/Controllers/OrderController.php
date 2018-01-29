<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Repositories\PromotionRepository;
use Carbon\Carbon;
use Datatables;
class OrderController extends Controller
{
    protected $order;

    public function __construct(OrderRepository $order, PromotionRepository $promotion)
    {
        $this->order = $order;
        $this->promotion = $promotion;
    }

    public function getIndex()
    {
        $order_quantity = $this->order->query(['id'])->count();
        return view('Admin::pages.order.index', compact('order_quantity'));
    }

    public function getData(Request $request)
    {
        $data = $this->order->query(['*'])
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('payment_methods', 'payment_methods.id', '=', 'orders.paymentmethod_id' )
            ->join('paymentstatus', 'paymentstatus.id', '=', 'orders.paymentstatus_id' )
            ->join('shipstatus', 'shipstatus.id', '=', 'orders.shipstatus_id' );

        return Datatables::of($data)
            ->addColumn('action', function($data){
                return '<a href="'.route('admin.category.edit', $data->id).'" class="btn btn-info btn-xs inline-block-span"> Chi tiết </a>';
            })->editColumn('orders.order_date', function($data){
                $date = Carbon::parse($data->created_at)->format('d/m/Y');
                return $date;
            })->editColumn('orders.total', function($data){
                $total = number_format($data->total);
                return $total;
            })->editColumn('customers.name',function($data){
                $name = $data->customers->lastname .' '.$data->customers->firstname;
                return $name;
            })
            ->editColumn('payment.method', function($data){
                $method = $data->paymentmethods->name;
                return $method;
            })
            ->editColumn('promotion.status', function($data){
                if($data->promotion_id){
                    $promotion = $this->promotion->find($$data->promotion_id)->sku_promotion;
                }else{
                    $promotion = "Không áp dụng";
                }
                return $promotion;
            })
            ->editColumn('shipstatus.name', function($data){
                $ship_list = \App\Models\ShipStatus::lists('description','code')->toArray();
                $select = view('Admin::ajax.orders.shipStatus', compact('ship_list','data'))->render() ;
                return $select;
            })
            ->editColumn('paymentstatus.name', function($data){
                $payment_list = \App\Models\PaymentStatus::lists('description','code')->toArray();
                $select = view('Admin::ajax.orders.paymentStatus', compact('payment_list','data'))->render() ;
                return $select;
            })
            ->filter(function($query) use ($request){
                if (request()->has('name')) {
                    $query->where('categories.name', 'like', "%{$request->input('name')}%")->orWhere('categories.sku_cate','like', "%{$request->input('name')}%");
                }
            })->setRowId('id')->make(true);
    }

    public function getDetail(Request $request, $id)
    {

    }

    public function postChangeShip(Request $request)
    {

    }

    public function postChangePayment(Request $request)
    {

    }
}
