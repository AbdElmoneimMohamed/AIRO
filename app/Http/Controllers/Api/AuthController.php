<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        $token = JWTAuth::attempt($credentials);

        if ($token) {
            return $this->sendSuccessResponse(data: [
                'token' => $token,
            ]);
        }

        return $this->sendErrorResponse('please check your password', Response::HTTP_FORBIDDEN);
    }
}
