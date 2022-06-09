<?php

namespace App\Http\Controllers\api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\api\v1\Auth\Request\RegisterRequest;
use App\Http\Controllers\api\v1\Common\DataResponse;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\Auth\RegisterRepositoryInterface;
use App\Utils\ErrorMessage;
use Error;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    //
    public $registerRepo;

    public function __construct(RegisterRepositoryInterface $registerRepo)
    {
        $this->registerRepo = $registerRepo;
    }

    public function registerUser(RegisterRequest $request) 
    {
        $response = new DataResponse();
        try {
            $response = $this->registerRepo->create($request->all());
        } catch (\Exception $e) {
            $response->setException($e);
        }
        return $response->getData();
    }
}
