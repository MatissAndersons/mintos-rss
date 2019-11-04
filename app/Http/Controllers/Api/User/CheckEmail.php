<?php

namespace App\Http\Controllers\Api\User;

use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class CheckEmail extends Controller
{
    /**
     * Check if a user with a respective email exists.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function exists(Request $request)
    {
        $email = $request->get('email');
        $exists = User::where('email', $email)->exists();

        return response()->json([
            'exists' => $exists,
            'message' => $exists ? 'You already have an account' : ''
        ]);
    }
}
