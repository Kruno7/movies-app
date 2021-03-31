<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @OA\POST(
     **  path="/api/login",
     *   tags={"Login"},
     *   summary="Login",
     *   operationId="login",
     *
     *   @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="Not Found"
     *   ),
     *   @OA\Response(
     *      response=422,
     *      description="Not found"
     *   ),
     *)
     **/
    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */


    public function login (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email|max:50',
            'password' => 'required|',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'There are incorect values in the form!',
                'errors'  => $validator->getMessageBag()->toArray()
            ], 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['error' => 'Unauthorised'], 401); 
        } else {
            $user  = Auth::user();
            $token = $user->createToken('token')->accessToken;
            return response()->json([
                'message' => 'success',
                'token'   => $token,
                'user'    => $user 
            ], 200); 
        } 
        
    }

    /**
     * @OA\Get(
     *      path="/api/user",
     *      operationId="user",
     *      tags={"User"},
     *      security={
     *      {"passport": {}},
     *   },
     *      summary="Get the details of an authenticated user",
     *      description="",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     */

    public function user ()
    {
        return Auth::user();
    }

    /**
     *  @OA\Post(
     **  path="/api/register",
     *   tags={"Register"},
     *   summary="Register",
     *   operationId="register",
     *
     *  @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   
     *   @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *     
     *   @OA\Response(
     *      response=201,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *  
     *   @OA\Response(
     *      response=404,
     *      description="Not found"
     *   ),
     *   @OA\Response(
     *       response=422,
     *       description="Unprocessable Entity"
     *   )
     *)
     **/
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */

    public function register (RegisterRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|max:50',
            'email'    => 'required|email|max:50',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'There are incorect values in the form!',
                'errors'  => $validator->getMessageBag()->toArray()
            ], 422);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        return response()->json([
            'message' => 'success',
            'user'    => $user
        ], 201);
    
    }
}
