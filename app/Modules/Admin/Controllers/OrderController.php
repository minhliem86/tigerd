<?php

namespace App\Modules\Admin\Controllers;

use GuzzleHttp\Psr7\Response;
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
        $data = $this->order->query(['orders.id', 'orders.order_name', 'orders.total', 'orders.customer_id', 'orders.promotion_id', 'orders.paymentmethod_id', 'orders.shipstatus_id', 'orders.paymentstatus_id'])
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('payment_methods', 'payment_methods.id', '=', 'orders.paymentmethod_id' )
            ->join('paymentstatus', 'paymentstatus.id', '=', 'orders.paymentstatus_id' )
            ->join('shipstatus', 'shipstatus.id', '=', 'orders.shipstatus_id' );

        return Datatables::of($data)
            ->addColumn('action', function($data){
                return '<a href="'.route('admin.order.detail', $data->id).'" class="btn btn-info btn-xs inline-block-span"> Chi tiết </a>';
            })->editColumn('orders.order_date', function($data){
                $date = Carbon::parse($data->created_at)->format('d/m/Y H:i');
                return $date;
            })->editColumn('orders.total', function($data){
                $total = number_format($data->total);
                return $total;
            })->editColumn('customers.name',function($data){
                $name = $data->customers->lastname .' '.$data->customers->firstname;
                return $name;
            })
            ->editColumn('method', function($data){
                $method = $data->paymentmethods->name;
                return $method;
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
           ->setRowId('id')->make(true);
    }

    public function getDetail(Request $request, $id)
    {
        $order = $this->order->find($id, ['*'],['customers','paymentmethods', 'paymentstatus', 'shipstatus','products']);
        return view('Admin::pages.order.show', compact('order'));
    }

    public function postChangeShip(Request $request)
    {
        if(!$request->ajax()){
            return response()->view('Admin::errors.404', '',404);
        }else{
            $value = $request->value;
            $id = $request->id;

            $order = $this->order->find($id);
            $order->shipstatus_id = $value;
            if($value == 3){
                $order->paymentstatus_id = 2;
                $order->save();
            }else{
                $order->save();
            }

            return response()->json(['error'=> false, 'data'=> $value], 200);
        }
    }

    public function postChangePayment(Request $request)
    {
        if(!$request->ajax()){
            return response()->view('Admin::errors.404', '',404);
        }else{
            $value = $request->value;
            $id = $request->id;
            $order = $this->order->find($id);
            $order->paymentstatus_id = $value;
            $order->save();

            return response()->json(['error'=> false, 'data'=> true], 200);
        }
    }
}