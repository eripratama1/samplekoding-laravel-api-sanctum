<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        /**
         * Jalankan proses validasi sebelum melakukan 
         * registrasi user
         */
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        /**
         * Proses create user baru
         */
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        /**
         * Dengan method createToken
         * User yang baru saja melakukan registrasi akan mendapatkan token
         * 
         */
        $token = $user->createToken('register_token')->plainTextToken;

        /**
         * Return response dalam bentuk json
         */
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Register Succeded',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function login(Request $request)
    {
        /**
         * Jalankan proses validasi terlebih dahulu
         */
        $fields = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        /**
         * Cek ke model User apa data yang diinputkan
         * sama dengan data yang ada pada DB / tabel
         */
        $user = User::where('email', $fields['email'])->first();
        /**
         * Jika tidak return response json berikut.
         */
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response()->json([
                'status' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Check your credentials'
            ]);
        }

        /**
         * Jika data valid
         * Buat token untuk user tersebut
         */
        $token = $user->createToken('login_token')->plainTextToken;
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Logged In',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        /**
         * Pada method logout lakukan proses hapus token user yang 
         * Melakukan login
         */
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Logged Out'
        ];
    }
}