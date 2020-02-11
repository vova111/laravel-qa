<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function getToken(Request $request)
    {
        $request->request->add([
            'grant_type' => 'password',
            'client_id' => 2,
            'client_secret' => 'PTkuvIvSp2Yjv0UnXuApm59DxGQv4YKxN1QIznVY',
            'username' => $request->username,
            'password' => $request->password,
        ]);

        // Так как в nginx не работают env переменные, пишем этот костыль
        // Надо найти способо подружить nginx с env
        $appUrl = 'http://127.0.0.1:8000';

        $requestToken = Request::create($appUrl . '/oauth/token', 'post');
        $response = Route::dispatch($requestToken);

        return $response;
    }
}
