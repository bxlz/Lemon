<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Models\User;
use Redirect,DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest', ['except' => 'logout']);
        $this->middleware('guest:user', ['except' => 'logout']);
    }

    public function showLoginForm()
    {
        return view('user.login');
    }

    protected function validator(array $data)
    {
        dd($data);
        return Validator::make($data, [
            'username' => 'required|max:255',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request->all(),[
            'username' => 'required',
            'password' => 'required',
            //'captcha' => 'required|captcha'
        ], [
            'username.required' => '用户名必填',
            'password.required' => '密码必须',
            //'captcha.captcha' => '验证码错误',
            //'captcha.required' => '验证码必须',
        ]);
        dd(132);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
        dd($request->all());
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        //dd($this->hasTooManyLoginAttempts($request));
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        $credentials = $this->credentials($request);
        if ($this->guard()->attempt($credentials, $request->has('remember'))) {
            $results = User::select('id','username')
                ->Where('username', '=', $request->input('username'))
                ->first();
            session(['user_id' => $results['id']]);
           return $this->sendLoginResponse($request);
        }
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
            $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function guard()
    {
        return auth()->guard('user');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return Redirect::route('user.login');
    }

    public function username()
    {
        return 'username';
    }
}

