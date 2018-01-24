<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\AttributeRepository;
use Validator;
use Yajra\Datatables\Datatables;

class AttributeController extends Controller
{
    protected $attribute;

    public function __construct(AttributeRepository $attribute)
    {
        $this->attribute = $attribute;
    }

    public function index()
    {
        return view('Admin::pages.attribute.index');
    }

    public function getData(Request $request)
    {
        $data = $this->attribute->query(['id', 'name' ,'description']);
        $datatable = Datatables::of($data)
            ->editColumn('description', function($data){
                return \Str::words($data->description, 20);
            })
            ->addColumn('action', function($data){
                return '<a href="'.route('admin.attribute.edit', $data->id).'" class="btn btn-info btn-xs inline-block-span"> Edit </a>';
            })
            ->filter(function($query) use ($request){
                if (request()->has('name')) {
                    $query->where('name', 'like', "%{$request->input('name')}%");
                }
            })
            ->make(true);
        return $datatable;
    }

    public function edit($id)
    {
        $attribute = $this->attribute->find($id);
        return view('Admin::pages.attribute.edit', compact('attribute'));
    }

    public function update(Request $request, $id)
    {
        $valid = Validator::make($request->all(), ['name'=>'required'], ['name.required' => 'Vui lòng nhập tên Thuộc tính']);
        if($valid->fails()){
            return redirect()->back()->withInput()->withErrors($valid);
        }
        $data = [
            'name' => $request->name,
            'slug' => \LP_lib::unicode($request->name),
            'description' => $request->description,
        ];

        $this->attribute->update($data, $id);
        return redirect()->route('admin.attribute.index');
    }

    public function getCreate(){
        if(\Session::has('url')){
            return view('Admin::pages.attribute.create', compact('url'));
        }else{
            return view('Admin::pages.attribute.create');
        }

    }

    public function postCreate(Request $request, AttributeRepository $attribute){
        $valid = Validator::make($request->all(), ['name' => 'required'], ['name.required' => 'Vui lòng Nhập tên Thuộc tính']);
        if($valid->fails()){
            return redirect()->back()->withInput()->withErrors($valid);
        }
        $data = [
            'name' => $request->input('name'),
            'slug' => \LP_lib::unicode($request->input('name')),
            'description' => $request->input('description')
        ];

        $attribute->create($data);
        if($request->has('url')){
            return redirect($request->url);
        }
        \Session::forget('url');
        return redirect()->route('admin.attribute.index');
    }
}
