<?php

namespace App\Modules\Client\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */
    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    protected $resetView = "Client::pages.auth.passwords.reset";

    public $redirectPath = '/';

    protected $broker = 'customers';

    protected $guard = 'customer';

    public function __construct()
    {
        $this->middleware('client_if_logined');
    }

    public function getEmail()
    {
      return view('Client::pages.auth.passwords.email_reset');
    }

    /*CUSTOM EMAIL ERROR*/
    protected function getSendResetLinkEmailFailureResponse($response)
    {
        return redirect()->back()->withErrors(['email' => "Không tìm thấy thông tin của email."], 'error_forget');
    }

    /*CUSTOMER RESET ERROR*/
    protected function getResetFailureResponse(Request $request, $response)
    {
        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)], 'error_reset');
    }
}
