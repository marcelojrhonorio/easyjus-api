<?php

namespace App\Http\Controllers;

use Log;
use App\Models\AdminUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserPasswordController extends Controller
{
    public function checkPassword(Request $request)
    {
        $id = $request->input('id');
        $currentPassword = $request->input('current_password');

        $adminUser = AdminUsers::find($id);

        if (false === Hash::check($currentPassword, $adminUser->password)) {
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

    public function changePassword(Request $request)
    {
        $id = $request->input('id');
        $newPassword = $request->input('new_password');

        $adminUser = AdminUsers::find($id);
        $adminUser->password = Hash::make($newPassword);
        $adminUser->save();

        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'data' => $adminUser,
        ]);
    }
}
