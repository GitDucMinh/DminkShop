<?php

namespace App\Http\Controllers\api\v1\Auth;

use App\Http\Controllers\api\v1\Auth\Request\LoginRequest;
use App\Http\Controllers\api\v1\Common\DataResponse;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\Auth\LoginRepositoryInterface;

class LoginController extends Controller
{
    public $loginRepo;

    public function __construct(LoginRepositoryInterface $loginRepo)
    {
        $this->loginRepo = $loginRepo;
        $this->middleware('jwtauth')->except('userLogin');
    }

    public function userLogin(LoginRequest $request)
    {
        $response = new DataResponse();
        try {
            $response = $this->loginRepo->login($request->all());
        } catch(\Exception $e) {
            $response->setException($e);
        }

        return $response;
    }

    public function isMe()
    {
        $response = new DataResponse();
        try {
            $response = $this->loginRepo->me();
        } catch(\Exception $e) {
            $response->getException($e);
        }
        
        return $response->getData();
    }

    public function userLogout()
    {
        $response = new DataResponse();
        try {
            $response = $this->loginRepo->logout();
        } catch(\Exception $e) {
            $response->setException($e);
        }

        return $response->getData();
    }
}
