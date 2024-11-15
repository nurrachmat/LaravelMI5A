<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request) {
        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
           $user = Auth::user(); // ambil data user dari tabel users sesuai dengan email dan pass
            if($user->role == 'admin'){
                $success['token'] = $user->createToken('MDPApp', ['create', 'read', 'update', 'delete'])->plainTextToken; // buat token
            } else {
                $success['token'] = $user->createToken('MDPApp', ['read'])->plainTextToken; // buat token
            }

            $success['name'] = $user->name; // response nama user
            return response()->json($success, 201); 
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
