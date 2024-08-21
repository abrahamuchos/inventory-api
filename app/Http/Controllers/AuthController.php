<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
           'email' => 'required|email',
           'password' => 'required|string|max:65'
        ]);

        if (!Auth::attempt($request->all())) {
            return response()->json([
                'error' => true,
                'message' => 'Email or password are invalid. Try Again.',
                'code' => 10000,
                'details' => 'Email or password are invalid. Try Again'
            ], 401);
        }

        $user = Auth::user();
        $token = $this->_createToken($user);

        return response()->json([
           'data' => [
               'token' => $token->plainTextToken,
               'expiredAt' => $token->accessToken->expires_at
           ]
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json([]);
    }

    /**
     * @param User $user
     *
     * @return \Laravel\Sanctum\NewAccessToken
     */
    private function _createToken(User $user): \Laravel\Sanctum\NewAccessToken
    {
        return $user->createToken('basic-token', ['create', 'update', 'delete'], now()->addHours(12));
    }
}
