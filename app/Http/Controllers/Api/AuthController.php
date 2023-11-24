<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use GrahamCampbell\ResultType\Success;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *  path="/api/login",
     *  operationId="authLogin",
     *  tags={"Authorization"},
     *  summary="User Login",
     *  description="User Login here",
     *  @OA\RequestBody(
     *      request="Login",
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *              type="object",
     *              required={"email", "password"},
     *              @OA\Property(property="email", type="email"),
     *              @OA\Property(property="password", type="password")
     *          )
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Login Successfully",
     *      @OA\JsonContent()
     *  ),
     *  @OA\Response(response=400, description="Bad request"),
     *  @OA\Response(response=404, description="Resource Not Found")
     * )
     */
    public function login(Request $request)
    {
        $validator = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($validator)) {
            return response()->json(['error' => 'Unauthorised'])->setStatusCode(401);
        } else {
            $success['token'] =  auth()->user()->createToken('authToken');
            $success['user'] = auth()->user();
            return response()->json(['success' => $success])->setStatusCode(200);
        }
    }

    /**
     * @OA\Post(
     *  path="/api/register",
     *  operationId="Register",
     *  tags={"Authorization"},
     *  summary="User Register",
     *  description="User Register here",
     *  @OA\RequestBody(
     *      request="Register",
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *              type="object",
     *              required={"name","email", "password", "password_confirmation"},
     *              @OA\Property(property="name", type="text"),
     *              @OA\Property(property="email", type="email"),
     *              @OA\Property(property="password", type="password"),
     *              @OA\Property(property="password_confirmation", type="password")
     *          )
     *      )
     *  ),
     *  @OA\Response(
     *      response=201,
     *      description="Register Successfully",
     *      @OA\JsonContent()
     *  ),
     *  @OA\Response(response=422, description="Unprocessable Entity"),
     *  @OA\Response(response=400, description="Bad request"),
     *  @OA\Response(response=404, description="Resource Not Found")
     * )
     */
    public function register(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $success['token'] =  $user->createToken('authToken')->accessToken;
        $success['user'] = $user;
        return response()->json(['success' => $success])->setStatusCode(201);
    }

    /**
     * @OA\Delete(
     *  path="/api/logout",
     *  summary="User Logout",
     *  description="User Logout here",
     *  operationId="authLogout",
     *  tags={"Authorization"},
     *  security={ {"bearer_token": {} }},
     *  @OA\Response(
     *      response=200,
     *      description="Successfully",
     *      @OA\JsonContent()
     *  ),
     *  @OA\Response(response=400, description="Bad request"),
     *  @OA\Response(response=403, description="Unauthenticated"),
     *  @OA\Response(response=404, description="Not Found")
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        $success['message'] = 'Successfully logged out';
        return response()->json(['success' => $success])->setStatusCode(200);
    }
}
