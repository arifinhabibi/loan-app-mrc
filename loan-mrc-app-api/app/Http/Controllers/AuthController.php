<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request){
        $validasi = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ], 
        [
            'username' => 'username belum di isi broo',
            'password' => 'password nua isi dulu broo'
        ]);

        if ($validasi->fails()) {
            # code...
            return response()->json([
                'message' => 'Invalid field',
                'error' => $validasi->errors()
            ], 401);
        }

        $credential = [
            'username' => $request->username,
            'password' => $request->password
        ];

        $user = Auth::attempt($credential);

        if (!$user) {
            # code...
            return response()->json([
                'message' => 'username atau password salah'
            ], 401);
        }

        
        Auth::user()->update([
            'tokens' => bcrypt('login')
        ]);
        
        Auth::user()->token = Auth::user()->tokens;
        

        return response()->json([
            'message' => 'login success',
            'user' => Auth::user()
        ], 200);
    }

    public function logout(Request $request){

        $user = User::where('tokens', $request->token)->first();

        if (!$user) {
            # code...
            return response()->json([
                'message' => 'invalid token'
            ], 401);
        }

        $user->update([
            'tokens' => null
        ]);

        Auth::logout();

        return response()->json([
            'message' => 'logout success'
        ]);


    }
}
