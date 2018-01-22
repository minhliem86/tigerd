<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\AttributeRepository;
use Validator;
class AttributeController extends Controller
{
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

        return redirect()->route('admin.product.index');
    }
}
