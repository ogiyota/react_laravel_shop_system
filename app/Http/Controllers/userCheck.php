<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class userCheck extends Controller
{
    public function check(Request $request){
        $id = $request->input('email');
        $data = User::where('email', $id)->first();
    
        if ($data) {
            return response()->json("OK");
        } else {
            return response()->json($request);
        }
    }

    public function login(Request $request){
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                    'message' => 'no user'
            ]);
        }
        return response()->json([
            'name' => $user -> name,
            'email' => $user -> email,
            'user_id' => $user -> user_id
        ]);
    }

    public function register(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed|min:8',
    ]);

    $user = new User();
    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];
    $user->password = Hash::make($validatedData['password']);
    $user->save();

    // ユーザー登録後に何らかの処理を実行する場合はここに記述する

    return response()->json(true);
}
}


