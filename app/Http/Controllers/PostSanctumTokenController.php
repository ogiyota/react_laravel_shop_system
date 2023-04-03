<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PostSanctumTokenController extends Controller
{
    public const TOKEN_NAME = 'app_api_token';
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                    'message' => 'no user'
            ]);
        }

        return response()->json([
            'accessToken' => $user->createToken(self::TOKEN_NAME)->plainTextToken
        ]);
    }
}
