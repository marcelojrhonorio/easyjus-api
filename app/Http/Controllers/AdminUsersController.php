<?php

namespace App\Http\Controllers;

use Log;
use App\Models\AdminUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUsersController extends Controller
{
    public function store (Request $request) 
    {
        $adminUser = new AdminUsers();
        $adminUser->fullname = $request->input('fullname');
        $adminUser->email = $request->input('email');
        $adminUser->password = Hash::make($request->input('password'));
        $adminUser->save();

        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'data' => $adminUser,
        ]);
    }

    public function verifyEmail(Request $request)
    {
        $email = $request->input('email') ?? 'not-found';
        $adminUser = AdminUsers::where('email', $email)->first();

        if (isset($adminUser->id)) {
            return response()->json([
                'success'  => false,
                'status'   => 'user_exists',
                'data' => [],
            ]);
        }

        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'data' => [],
        ]);
    }

    public function getByEmail (Request $request) {
        $email = $request->input('email');
        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'data' => AdminUsers::where('email', $email)->first(),
        ]);
    }

    public function getRecoveryPasswordToken (Request $request) {
        $id = $request->input('id') ?? null;

        $adminUser = AdminUsers::find($id);
        $adminUser->token = md5(uniqid(rand(), true));
        $adminUser->save();

        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'data' => $adminUser->token,
        ]);
    }

    public function getUserByToken (Request $request) {
        $token = $request->input('token');

        $adminUser = AdminUsers::where('token', $token)->first();

        if (false == (isset($adminUser->id))) {
            return response()->json([
                'success'  => false,
                'status'   => 'invalid_token',
                'data' => [],
            ]);
        }

        $adminUser->token = null;
        $adminUser->save();

        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'data' => $adminUser,
        ]);
    }

    public function changePassword (Request $request)
    {
        $id = $request->input('id');
        $password = $request->input('password');

        $adminUser = AdminUsers::find($id);
        $adminUser->password = Hash::make($password);
        $adminUser->save();

        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'data' => $adminUser,
        ]);
    }

    public function changeAdminUser($id, Request $request) {
        $adminUser = AdminUsers::find($id);
        $adminUser->fullname = $request->input('fullname');
        $adminUser->save();

        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'data' => $adminUser,
        ]);
    }

    public function search ()
    {
        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'data' => AdminUsers::all(),
        ]);
    }

    public function destroy ($id) 
    {
        $adminUser = AdminUsers::find($id);
        $adminUser->delete();

        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'data' => [],
        ]);
    }

    public function blockAdminUser ($id)
    {
        $adminUser = AdminUsers::find($id);
        $adminUser->enabled = false;
        $adminUser->save();

        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'data' => [],
        ]);
    }
}
