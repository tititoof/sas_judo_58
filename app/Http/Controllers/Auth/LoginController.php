<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Carbon\Carbon;

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
        $this->middleware('guest')->except('logout');
    }

    public function signin(Request $request)
    {
        try {
            $token = JWTAuth::attempt($request->only('email', 'password'),
                ['exp'   => Carbon::now()->addWeek()->timestamp,]);
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Could not authenticate',
            ], 500);
        }
        if (!$token) {
            return response()->json(['error' => 'Could not authenticate'], 401);
        } else {
            $data = [];
            $meta = [];
            $data['name']       = $request->user()->name;
            $data['user_id']    = $request->user()->id;
            $data['email']      = $request->user()->email;
            $data['is_admin']   = $request->user()->is_admin;
            $data['is_debug']   = $request->user()->is_debug;
            $meta['token']      = $token;
            return response()->json(['data' => $data, 'meta' => $meta]);
        }
    }
}
