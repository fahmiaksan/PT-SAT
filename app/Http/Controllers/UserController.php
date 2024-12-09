<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function register(UserRegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (User::where('username', $data['username'])->count() == 1) {
            throw new HttpResponseException(response([
                "errors" => [
                    "username" => [
                        "username already registered"
                    ]
                ]
            ], 400));
        }

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'User registered successfully!',
            'data' => $user,
        ], 201);
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (!$token = JWTAuth::attempt($data)) {
            return response()->json([
                'message' => 'Invalid email or password.'
            ], 401); // 401 Unauthorized
        }
        return response()->json([
            'message' => 'Login successful!',
            'user' => Auth::user(),
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 200);
    }

    public function get(Request $request): JsonResponse
    {
        if (!$request->header('Authorization')) {
            return response()->json([
                "errors" => [
                    "message" => [
                        "unauthorized"
                    ]
                ]
            ]);
        }
        return response()->json([
            'data' => Auth::user()
        ], 200);
    }

    public function update(UserUpdateRequest $request, $id): JsonResponse
    {

        $user = User::find($id);

        if (!$user) {
            throw new HttpResponseException(response([
                "errors" => [
                    "message" => [
                        "user not found"
                    ]
                ]
            ], 404));
        }

        if (isset($request->password) || isset($request->name) || isset($request->username)) {
            if (isset($request->password)) {
                $user->password = Hash::make($request->password);
            }
            if (isset($request->name)) {
                $user->name = $request->name;
            }
            if (isset($request->username)) {
                $user->username = $request->username;
            }
            $user->update();
            return response()->json([
                'message' => 'success update',
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'message' => 'error update',
            ], 400);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json([
            "data" => true
        ])->setStatusCode(200);
    }
}
