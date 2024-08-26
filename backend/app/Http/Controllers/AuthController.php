<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;

class AuthController extends Controller
{

    public function __construct(
        protected AuthService $authService
    ) {
        $this->authService = $authService;
    }

    public function store(Request $request)
    {
        $token = $this->authService->createToken($request);
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    public function destroy(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Successfuly logged out.',
        ]);
    }
}
