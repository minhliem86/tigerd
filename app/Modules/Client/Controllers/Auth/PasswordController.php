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
    protected $resetView = "Client::pages.auth.passwords.email_reset";
    public $redirectPath = 'dang-nhap';


    protected $guard = 'customer';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function resetView()
    {
      return 'Client::pages.auth.passwords.email_reset';
    }

    public function showResetForm(Request $request, $token = null)
    {
        if (is_null($token)) {
            return $this->getEmail();
        }

        $email = $request->input('email');

        if (property_exists($this, 'resetView')) {
            return view($this->resetView)->with(compact('token', 'email'));
        }

        if (view()->exists('Client::pages.auth.passwords.reset')) {
            return view('Client::pages.auth.passwords.reset')->with(compact('token', 'email'));
        }

        return view('Client::pages.auth.passwords.reset')->with(compact('token', 'email'));
    }

    public function getEmail()
    {
      return view('Client::pages.auth.passwords.email_reset');
    }

    protected function getSendResetLinkEmailFailureResponse($response)
    {
        return redirect()->back()->withErrors(['email' => "Không tìm thấy thông tin của email."], 'error_forget');
    }
}
