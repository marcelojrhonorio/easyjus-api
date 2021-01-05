<?php

namespace App\Http\Controllers;

use Log;
use Illuminate\Http\Request;
use App\Models\AdminUserMenu;

class AdminUsersMenusController extends Controller
{
    public function store (Request $request)
    {
        $menuId = $request->input('menu_id');
        $adminUserId = $request->input('admin_user_id');

        if (null === $menuId) {
            return response()->json([
                'success' => false,
                'status' => 'invalid_menu_id',
                'message' => '',
                'data' => []
            ]);
        }

        if (null === $adminUserId) {
            return response()->json([
                'success' => false,
                'status' => 'invalid_admin_user_id',
                'message' => '',
                'data' => []
            ]);
        }

        try {
            
            $adminUserMenu = new AdminUserMenu();
            $adminUserMenu->menu_id = $menuId;
            $adminUserMenu->admin_user_id = $adminUserId;
            $adminUserMenu->save();

        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'success'  => false,
                'status'   => 'unkdown_error',
                'message' => 'Ocorreu um erro desconhecido. Contate o administrador da plataforma.',
                'data' => [],
            ]);
        }

        return response()->json([
            'success' => true,
            'status' => 'success',
            'message' => '',
            'data' => []
        ]);

    }

    public function listAll ()
    {
        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'message' => '',
            'data' => AdminUserMenu::all(),
        ]);
    }

    public function edit (Request $request, $id)
    {
        $menuId = $request->input('menu_id');
        $adminUserId = $request->input('admin_user_id');
        
        $adminUserMenu = AdminUserMenu::find($id);

        if (null === $adminUserMenu) {
            return response()->json([
                'success' => false,
                'status' => 'invalid_admin_user_menu',
                'message' => '',
                'data' => []
            ]);            
        }

        if (null === $menuId) {
            return response()->json([
                'success' => false,
                'status' => 'invalid_menu_id',
                'message' => '',
                'data' => []
            ]);
        }

        if (null === $adminUserId) {
            return response()->json([
                'success' => false,
                'status' => 'invalid_admin_user_id',
                'message' => '',
                'data' => []
            ]);
        }

        try {
            
            $adminUserMenu->menu_id = $menuId;
            $adminUserMenu->admin_user_id = $adminUserId;
            $adminUserMenu->save();

        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'success'  => false,
                'status'   => 'unkdown_error',
                'message' => 'Ocorreu um erro desconhecido. Contate o administrador da plataforma.',
                'data' => [],
            ]);
        }

        return response()->json([
            'success' => true,
            'status' => 'success',
            'message' => 'Edição feita com sucesso.',
            'data' => []
        ]);
    }

    public function getById ($id)
    {
        $adminUserMenu = AdminUserMenu::find($id);

        if (null === $adminUserMenu) {
            return response()->json([
                'success' => false,
                'status' => 'invalid_admin_user_menu',
                'message' => '',
                'data' => []
            ]);            
        }

        return response()->json([
            'success' => true,
            'status' => 'success',
            'message' => '',
            'data' => $adminUserMenu
        ]);
    }

    public function destroy ($id)
    {
        $adminUserMenu = AdminUserMenu::find($id);

        if (null === $adminUserMenu) {
            return response()->json([
                'success' => false,
                'status' => 'invalid_admin_user_menu',
                'message' => '',
                'data' => []
            ]);            
        }
        
        $adminUserMenu->delete();

        return response()->json([
            'success' => true,
            'status' => 'success',
            'message' => '',
            'data' => []
        ]);
    }
}
