<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Traits\ResponseTrait;
use App\Repositories\AuthRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    use ResponseTrait;
    public $authAccess;

    public function __construct(AuthRepository $authAccess)
    {
        $this->authAccess = $authAccess;
    }


    public function profile():JsonResponse
    {
        try{
           $loggedINuserData = Auth::guard()->user();
           return $this->responseSuccess($loggedINuserData,'Hello '.$loggedINuserData->name);
        }catch(Exception $e){
            return $this->responseError([],$e->getMessage());
        }

    }



}




