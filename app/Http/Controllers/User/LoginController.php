<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use Redirect,DB,Session;

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
    protected $redirectTo = '/user/home';

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

    public function checkIfExist(Request $request)
    {
        //dd($request->all());
        $username = $request['username'];
        $password = $request['password'];
        /*if($username=='admin'&&$password=='123456'){
            return response()->json(array('status' => 'true'));
        }*/
        $users = User::where('password',bcrypt($password))
            ->where('username', $username)
            ->count();

        if($users<1){
            return response()->json(array('status' => 'false'));
        }
        else{
            return response()->json(array('status' => 'true'));
        }
    }

    public function login(Request $request)
    {
        //dd(Hash::make("123456"));
        //$this->validateLogin($request);
        //dd($request->all());
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        //dd($this->hasTooManyLoginAttempts($request));
        //hasTooManyLoginAttempts()判断当前的登录次数是否超过限制，如果超过限制，则触发一个锁定事件并通知其监听者,然后返回一个锁定的响应。
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        $credentials = $this->credentials($request);
        //dd($credentials);
        if ($this->guard()->attempt($credentials, $request->has('remember'))) {
            $results = User::select('id','username')
                ->Where('username', '=', $request->input('username'))
                ->first();
            session(['user_id' => $results['id']]);
            session(['username' => $results['username']]);
           return $this->sendLoginResponse($request);
        }else{
            dd($this->guard()->attempt($credentials, $request->has('remember')));
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

