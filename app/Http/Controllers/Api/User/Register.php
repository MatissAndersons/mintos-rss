<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Contracts\Hashing\Hasher;

class Register extends Controller
{
    /**
     * @var Hasher
     */
    protected $hasher;

    /**
     * TestUserSeeder constructor.
     *
     * @param Hasher $hasher
     */
    public function __construct(Hasher $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * Creates a user, if doesn't exist.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $email = $request->get('email');

        /** @var User $user */
        $user = User::firstOrNew(['email' => $email]);

        if (!$user->exists) {
            $password = $request->get('password');
            $user->setPassword($password)->save();

            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully',
                'email' => $email,
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => sprintf('User with email %s address already exists.', $email),
        ], 409);
    }
}
