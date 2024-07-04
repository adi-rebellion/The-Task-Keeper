<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Repositories\AuthRepository;
use Exception;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{

    use ResponseTrait;
    public $authAccess;

    public function __construct(AuthRepository $authAccess)
    {
        $this->authAccess = $authAccess;
    }

   /**
 * @OA\Post(
 *     path="/api/register",
 *     tags={"Authentication"},
 *     summary="User Registration",
 *     description="Register a new user to TaskKeeper with their name, email address, and password.",
 *     operationId="register",
 *     @OA\RequestBody(
 *         description="User registration data",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(
 *                     property="name",
 *                     description="User's full name",
 *                     type="string",
 *                     example="John Doe"
 *                 ),
 *                 @OA\Property(
 *                     property="email",
 *                     description="User's email address",
 *                     type="string",
 *                     example="john.doe@example.com"
 *                 ),
 *                 @OA\Property(
 *                     property="password",
 *                     description="Password for the user account",
 *                     type="string",
 *                     example="password123"
 *                 ),
 *                 @OA\Property(
 *                     property="password_confirmation",
 *                     description="Confirmation of the password",
 *                     type="string",
 *                     example="password123"
 *                 ),
 *                 required={"name", "email", "password", "password_confirmation"}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="User registered successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="message",
 *                 description="Success message",
 *                 type="string",
 *                 example="User registered successfully"
 *             ),
 *             @OA\Property(
 *                 property="user",
 *                 description="Registered user details",
 *                 type="object",
 *                 @OA\Property(
 *                     property="id",
 *                     description="User ID",
 *                     type="integer",
 *                     example=1
 *                 ),
 *                 @OA\Property(
 *                     property="name",
 *                     description="User's full name",
 *                     type="string",
 *                     example="John Doe"
 *                 ),
 *                 @OA\Property(
 *                     property="email",
 *                     description="User's email address",
 *                     type="string",
 *                     example="john.doe@example.com"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input data",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="error",
 *                 description="Error message",
 *                 type="string",
 *                 example="Invalid input data"
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


    public function register(RegisterRequest $request):JsonResponse
    {
        try{
           $registeredUserData = $this->authAccess->registerUser($request->all());
           return $this->responseSuccess($registeredUserData,'User registered successfully.');
        }catch(Exception $e){
            return $this->responseError([],$e->getMessage());
        }

    }
}



