<?php

namespace App\Modules\Client\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->auth = Auth::guard('customer');
        $this->middleware('client_checklogin');
    }

    private function _rulesProfile()
    {
        return [
          'firstname' => 'required',
            'lastname' => 'required',
            'phone' => 'required',
            'username' => 'required|max:200',
        ];
    }

    private function _rulesChangePass()
    {
        return [
            'oldPassword' => 'required',
            'newPassword' => 'required|confirmed',
        ];
    }

    private function _messageProfile()
    {
        return [
          'firstname.required' => 'Vui lòng điền Tên',
          'lastname.required' => 'Vui lòng điền Họ',
          'phone.required' => 'Vui lòng điền Số điện thoại',
          'username.required' => 'Vui lòng điền Số điện thoại',
          'username.max' => 'Tối đa 200 ký tự',
        ];
    }

    private function _messageChangePass()
    {
        return [
            'oldPassword.required' => 'Vui lòng nhập Password cũ',
            'newPassword.required' => 'Vui lòng nhập Password mới',
        ];
    }


    public function getProfile(Request $request)
    {
        return view('Client::pages.auth.profile');
    }

    public function postProfile(Request $request)
    {
        $valid = Validator::make($request->all(), $this->_rulesProfile(), $this->_messageProfile());
        if($valid->fails()){
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }
        $user =$this->auth()->user();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->phone = $request->phone;
        $user->username = $request->username;
        $user->save();

        return redirect()->back()->with('success', 'Cập Nhật Thành Công');
    }

    public function postChangePass(Request $request)
    {

    }
}
