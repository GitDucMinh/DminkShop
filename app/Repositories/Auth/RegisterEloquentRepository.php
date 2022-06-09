<?php

namespace App\Repositories\Auth;

use App\Repositories\Interfaces\Auth\RegisterRepositoryInterface;
use App\Models\User;
use App\Http\Controllers\api\v1\Common\DataResponse;
use App\Http\Controllers\api\v1\Common\ResponseCode;
use App\Utils\ErrorMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterEloquentRepository implements RegisterRepositoryInterface
{
    /**
     * Create
     * @param $param
     * @return mixed
     */
    public function create(array $param)
    {
        $response = new DataResponse();
        
        DB::beginTransaction();
        
        try {
            $user = new User();
            $isExistEmail = $this->isExistEmail($param['email']);
            
            if($isExistEmail) {
                $response->MessageNo = 'E001';
                $response->Code = ResponseCode::HAVE_ERROR;
                return $response;
            }
            
            $user->name = $param['name'];
            $user->email = $param['email'];
            $user->password = Hash::make($param['password']);
            $user->save();

            //Create token
            $token = Auth::login($user);

            DB::commit();
            $response->Data = [
                'authorisation' => [
                    'token' => $token,
                    'type'  => 'bearer',
                ]
            ];

        } catch(\Exception $e) {
            DB::rollBack();
            $response->Code = ResponseCode::HAVE_ERROR;
            $response->MessageNo = 'E003'; 
        }

        return $response;
    }

    public function isExistEmail($email)
    {
        return User::where('email', $email)->exists();
    }

}