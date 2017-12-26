<?php

namespace App\Modules\Admin\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\CustomerRepository;
use Datatables;

class CustomerController extends Controller
{
    protected $customer;

    public function __construct( CustomerRepository $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer_quality = $this->customer->all(['id'])->count();
        return view('Admin::pages.customer.index', compact('customer_quality'));
    }

    public function getData(Request $request)
    {
        $data = $this->customer->query(['id', 'firstname', 'lastname', 'username', 'phone', 'gender', 'created_at']);
        $datatable = Datatables::of($data)
            ->editColumn('gender', function($data){
                $gender = $data->gender ? 'Mr.' : 'Ms.';
                return $gender;
            })
            ->editColumn('created_at', function($data){
                $create_date = date_create($data->created_at)->format('d-m-Y');
                return $create_date;
            })
            ->addColumn('action', function($data){
                return '<a href="'.route('admin.customer.show', $data->id).'" class="btn btn-info btn-xs inline-block-span"> Thông tin </a>' ;
            })
            ->filter(function($query) use ($request){
                if (request()->has('name')) {
                    $query->where('firstname', 'like', "%{$request->input('name')}%")->orWhere('lastname', 'like', "%{$request->input('name')}%");
                }
            })
            ->make(true);
        return $datatable;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inst = $this->customer->find($id);
        return view('Admin::pages.customer.edit', compact('inst'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
