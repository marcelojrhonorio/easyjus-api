<?php

namespace App\Http\Controllers;

use Log;
use Illuminate\Http\Request;
use App\Models\AdminUserModule;

class AdminUsersModulesController extends Controller
{
    public function store(Request $request)
    {
        $moduleId    = $request->input('module_id');
        $adminUserId = $request->input('admin_user_id');

        if (null === $moduleId) {
            return response()->json([
                'success' => false,
                'status' => 'invalid_module_id',
                'message' => 'ID do Módulo não informado.',
                'data' => []
            ]);
        }

        if (null === $adminUserId) {
            return response()->json([
                'success' => false,
                'status' => 'invalid_admin_user_id',
                'message' => 'ID do Usuário Administrador não informado.',
                'data' => []
            ]);
        }

        try {
            
            $adminUserModule = new AdminUserModule();
            $adminUserModule->module_id = $moduleId;
            $adminUserModule->admin_user_id = $adminUserId;
            $adminUserModule->save();

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
            'message' => 'Cadastro realizado com sucesso.',
            'data' => $adminUserModule
        ]);
    }

    public function listAll ()
    {
        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'message' => '',
            'data' => AdminUserModule::all(),
        ]);
    }

    public function edit (Request $request, $id)
    {
        $moduleId    = $request->input('module_id');
        $adminUserId = $request->input('admin_user_id');

        if (null === $moduleId) {
            return response()->json([
                'success' => false,
                'status' => 'invalid_module_id',
                'message' => 'ID do Módulo não informado.',
                'data' => []
            ]);
        }

        if (null === $adminUserId) {
            return response()->json([
                'success' => false,
                'status' => 'invalid_admin_user_id',
                'message' => 'ID do Usuário Administrador não informado.',
                'data' => []
            ]);
        }

        $adminUserModule = AdminUserModule::find($id);

        if (null === $adminUserModule) {
            return response()->json([
                'success' => false,
                'status' => 'admin_user_module_not_found',
                'message' => 'Admin User Module não encontrado.',
                'data' => []
            ]);
        }

        try {
            
            $adminUserModule->module_id = $moduleId;
            $adminUserModule->admin_user_id = $adminUserId;
            $adminUserModule->save();

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
        $adminUserModule = AdminUserModule::find($id);

        if (null === $adminUserModule) {
            return response()->json([
                'success' => false,
                'status' => 'admin_user_module_not_found',
                'message' => '',
                'data' => []
            ]);
        }

        return response()->json([
            'success' => true,
            'status' => 'success',
            'message' => '',
            'data' => $adminUserModule
        ]);
    }

    public function destroy ($id)
    {
        $adminUserModule = AdminUserModule::find($id);

        if (null === $adminUserModule) {
            return response()->json([
                'success' => false,
                'status' => 'admin_user_module_not_found',
                'message' => '',
                'data' => []
            ]);
        }

        $adminUserModule->delete();

        return response()->json([
            'success' => true,
            'status' => 'success',
            'message' => '',
            'data' => []
        ]);
    }
}
