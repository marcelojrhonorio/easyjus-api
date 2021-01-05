<?php

namespace App\Http\Controllers;

use App\Models\AdminUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login (Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $adminUser = AdminUsers::where('email', $email)->first();

        if (!$adminUser->enabled) {
            return response()->json([
                'success'  => false,
                'status'   => 'login_forbidden',
                'data' => [],
            ]);
        }

        if(false === isset($adminUser->id)) {
            return response()->json([
                'success'  => false,
                'status'   => 'user_not_exists',
                'data' => [],
            ]);
        }

        if (false === Hash::check($password, $adminUser->password)) {
            return response()->json([
                'success'  => false,
                'status'   => 'password_do_not_match',
                'data' => [],
            ]);
        }

        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'data' => $adminUser,
        ]);
    }
}
