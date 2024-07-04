<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Repositories\AuthRepository;
use Exception;
use Auth;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{

    use ResponseTrait;
    public $authAccess;

    public function __construct(AuthRepository $authAccess)
    {
        $this->authAccess = $authAccess;
    }

       /**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="User Login",
 *     description="Allows a user to log in to TaskKeeper using their email address and password.",
 *     operationId="login",
 *     @OA\RequestBody(
 *         description="Credentials required to log in",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/x-www-form-urlencoded",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(
 *                     property="email",
 *                     description="User's email address",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="password",
 *                     description="User's password",
 *                     type="string"
 *                 ),
 *                 required={"email", "password"}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Login successful",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="token",
 *                 description="Authentication token",
 *                 type="string"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Invalid email or password"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */

    public function login(LoginRequest $request):JsonResponse
    {
        try{
           $authenticatedUserData = $this->authAccess->loginUser($request->all());
           return $this->responseSuccess($authenticatedUserData,'Logged in successfully.');
        }catch(Exception $e){
            return $this->responseError([],$e->getMessage());
        }

    }



/**
 * @OA\Post(
 *     path="/api/logout",
 *     tags={"Authentication"},
 *     summary="User Logout",
 *     description="Logs out the authenticated user and invalidates their session token.",
 *     operationId="logout",
 *     security={{"bearer":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Logout successful",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="message",
 *                 description="Success message",
 *                 type="string",
 *                 example="User logged out successfully"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="error",
 *                 description="Error message",
 *                 type="string",
 *                 example="Invalid or missing authentication token"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="error",
 *                 description="Error message",
 *                 type="string",
 *                 example="Internal server error"
 *             )
 *         )
 *     )
 * )
 */

    public function logout():JsonResponse
    {
        try{
             Auth::guard()->user()->token()->revoke();
             Auth::guard()->user()->token()->delete();
            return $this->responseSuccess('','User logged out successfully.');
        }catch(Exception $e){
            return $this->responseError([],$e->getMessage());
        }

    }
}
