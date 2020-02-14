<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

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

    public function destroy(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->noContent();
    }
}
