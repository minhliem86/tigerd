<?php

namespace App\Modules\Client\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use DB;
use App\Http\Controllers\Controller;
use App\Repositories\SubcribeRepository;

class ExtensionController extends Controller
{
    protected $subcribe;

    public function __construct(SubcribeRepository $subcribe)
    {
        $this->subcribe = $subcribe;
    }

    /*SUBSCRIBE*/
    public function postSubscribe(Request $request)
    {
        $valid = Validator::make($request->all(), ['email_subcribe' => 'required|email'], ['email_subcribe.required'=>'Vui lòng nhập Email', 'email_subcribe.email'=> 'Vui lòng nhập định dạng Email']);
        if($valid->fails()){
            return back()->withErrors($valid, 'error_subcribe');
        }
        $data = [
            'email' => $request->input('email_subcribe'),
        ];
        $this->subcribe->create($data);
        return back()->with('success_subscribe', 'Cảm ơn bạn đã Subscribe website chúng tôi.');
    }

    public function postSubscribeHeader(Request $request)
    {
        $valid = Validator::make($request->all(), ['email_subcribe_header' => 'required|email'], ['email_subcribe_header.required'=>'Vui lòng nhập Email', 'email_subcribe_header.email'=> 'Vui lòng nhập định dạng Email']);
        if($valid->fails()){
            return back()->withErrors($valid, 'error_subcribe_header');
        }
        $data = [
            'email' => $request->input('email_subcribe_header'),
        ];
        $this->subcribe->create($data);
        return back()->with('success_subscribe', 'Cảm ơn bạn đã Subscribe website chúng tôi.');
    }
    public function postSubscribeHeader(Request $request)
    {
        $valid = Validator::make($request->all(), ['email_subcribe_header' => 'required|email'], ['email_subcribe.required'=>'Vui lòng nhập Email', 'email_subcribe.email'=> 'Vui lòng nhập định dạng Email']);
        if($valid->fails()){
            return back()->withErrors($valid, 'error_subcribe_header');
        }
        $data = [
            'email' => $request->input('email_subcribe_header'),
        ];
        $this->subcribe->create($data);
        return back()->with('success', 'Cảm ơn bạn đã Subscribe website chúng tôi.');
    }

    public function postSearch(Request $request)
    {
        if(!$request->keywords){
            return back()->with('error','Vui lòng nhập từ khóa.');
        }

        $result = DB::table('products')->join('categories', function ($join) use ($request){
            $join->on('products.category_id', '=', 'categories.id');
        })->where('categories.name','like','%'.$request->keywords.'%')->orWhere('products.name', 'like', '%'.$request->keywords.'%')->paginate(10);

        return view('Client::pages.extension.search', compact('result'));
    }
}
