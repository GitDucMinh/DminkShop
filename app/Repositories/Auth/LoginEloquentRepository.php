<?php

namespace App\Repositories\Auth;

use App\Http\Controllers\api\v1\Common\DataResponse;
use App\Http\Controllers\api\v1\Common\ResponseCode;
use App\Repositories\Interfaces\Auth\LoginRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class LoginEloquentRepository implements LoginRepositoryInterface
{
    public function login($param)
    {
        $response = new DataResponse();
        $token = Auth::attempt($param);
        if (!$token) {
            $response->Code = ResponseCode::UNAUTHORIZED;
            return $response;
        }

        $user = Auth::user();
        return $response->Data = [
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ];
        return $response;
    }

    public function me()
    {
        $response = new DataResponse();
        $response->Data = Auth::user();
        return $response;
    }

    public function logout()
    {
        $response = new DataResponse();
        Auth::logout();

        $response->Data = [];
        return $response;
    }
}
