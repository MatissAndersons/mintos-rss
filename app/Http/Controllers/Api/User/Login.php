<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller;

class Login extends Controller
{
    /**
     * Responds with a token (JWT) if authentication is successful.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->all(['email', 'password']);

        if ($token = Auth::attempt($credentials)) {
            return response()->json([
                'token' => $token
            ]);
        }

        return abort(401);
    }
}
