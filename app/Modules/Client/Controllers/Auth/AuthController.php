<?php
namespace App\Modules\Client\Controllers\Auth;

use App\Models\User;
use Validator;
use Auth;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Models\Customer;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected $redirectPath = '/';


    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('client_if_logined', ['except' => ['logout']]);
        $this->auth = Auth::guard('customer');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:customers',
            'phone' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);
    }

    private function validator_create(array $data)
    {
        return Validator::make($data, [
           'lastname' => 'required',
            'firstname' => 'required',
            'phone' => 'required',
            'username' => 'required|unique:customers',
            'email'=> 'required|email|unique:customers',
            'password' => 'required|min:6|confirmed',
        ],[
            'lastname.required' => 'Vui lòng nhập Họ',
            'firstname.required' => 'Vui lòng nhập Tên',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'email.required' => 'Vui lòng nhập Email',
            'email.email' => 'Định dạng Email: abc@..',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Vui lòng nhập Password',
            'username.required' => 'Vui lòng nhập Username',
            'username.unique' => 'Username đã tồn tại',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return Customer::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function showLoginForm(){
      return view('Client::pages.auth.login');
    }

    public function login(Request $request)
    {
        $field = filter_var($request->usernameOrEmail, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $request->merge([$field => $request->usernameOrEmail]);
        if ($this->auth->attempt($request->only($field, 'password')))
        {
            return redirect('/');
        }
        return redirect()->back()->withInput()->withErrors([
            'error_login' => 'Thông tin đăng nhập không chính xác.',
        ]);
    }

    public function register(Request $request)
    {
        $validator = $this->validator_create($request->all());

        if ($validator->fails()) {
//            $this->throwValidationException(
//                $request, $validator
//            );
            return redirect()->back()->withInput()->withErrors($validator, 'register_error');
        }
        $user = $this->create($request->all());
        $this->auth->login($user);

        return redirect($this->redirectPath());
    }

    public function registerByAdmin(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        $user = $this->create($request->all());
        $role = Role::findOrFail($request->input('role_id'));
        $user->attachRole($role);

        return redirect()->route('admin.user.index')->with('success', 'User is created !');
    }

    public function logout()
    {
      $this->auth->logout();
      return redirect('/')->with('success', 'Cảm ơn bạn đã ghé thăm website của chúng tôi.');
    }

}
