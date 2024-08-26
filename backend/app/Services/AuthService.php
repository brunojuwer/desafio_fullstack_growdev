<?php

namespace App\Services;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class AuthService
{

  public function createToken(Request $request): string
  {
    $this->validateCredentials($request);
    $request->user()->tokens()->delete();
    $mentor = $request->user();
    $expirationDateTime = (new DateTime())->modify('+8 hours');
    $tokenResult = $mentor->createToken($mentor->email, [$mentor->role], $expirationDateTime);
    return $tokenResult->plainTextToken;
  }


  private function validateCredentials(Request $request)
  {
    $request->validate([
      'email' => 'required|string|email',
      'password' => 'required|string',
    ]);

    $credentials = request(['email', 'password']);
    if (!Auth::attempt($credentials)) {
      throw new UnauthorizedException('Bad credentials');
    }
  }
}
