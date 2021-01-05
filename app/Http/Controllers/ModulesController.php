<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Module;
use Illuminate\Http\Request;

class ModulesController extends Controller
{
    public function store (Request $request)
    {
        $moduleName = $request->input('name');

        if (null === $moduleName) {
            return response()->json([
                'success'  => false,
                'status'   => 'invalid_nodule_name',
                'message' => 'O nome do módulo é inválido.',
                'data' => [],
            ]);
        }

        try {

            $module = new Module();
            $module->name = $moduleName;
            $module->save();

        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'success'  => false,
                'status'   => 'module_already_exists',
                'message' => 'Já existe um módulo cadastrado com esse nome.',
                'data' => [],
            ]);
        }

        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'message' => 'Módulo cadastrado com sucesso.',
            'data' => $module,
        ]);        
    }

    public function edit (Request $request, $id)
    {
        $moduleName = $request->input('name');

        if (null === $moduleName) {
            return response()->json([
                'success'  => false,
                'status'   => 'invalid_nodule_name',
                'message' => 'O nome do módulo é inválido.',
                'data' => [],
            ]);
        }

        $module = Module::find($id);

        if (null === $module) {
            return response()->json([
                'success'  => false,
                'status'   => 'module_not_found',
                'message' => 'Módulo não encontrado.',
                'data' => [],
            ]);
        }

        try {
            
            $module->name = $moduleName;
            $module->save();

        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'success'  => false,
                'status'   => 'module_already_exists',
                'message' => 'Já existe um módulo cadastrado com esse nome.',
                'data' => [],
            ]);
        }


        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'message' => 'Módulo alterado com sucesso.',
            'data' => $module,
        ]);   

    }

    public function getById (Request $request, $id)
    {
        $module = Module::find($id);

        if (null === $module) {
            return response()->json([
                'success'  => false,
                'status'   => 'module_not_found',
                'message' => 'Módulo não encontrado.',
                'data' => [],
            ]);
        }

        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'message' => '',
            'data' => $module,
        ]);         
    }

    public function listModules ()
    {
        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'message' => '',
            'data' => Module::all(),
        ]);         
    }

    public function destroy ($id)
    {
        $module = Module::find($id);

        if (null === $module) {
            return response()->json([
                'success'  => false,
                'status'   => 'module_not_found',
                'message' => 'Módulo não encontrado.',
                'data' => [],
            ]);
        }
        
        $module->delete();

        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'message' => 'Módulo deletado com sucesso',
            'data' => [],
        ]);

    }

    public function getAllowedModules ($userId)
    {
        $adminUser = \App\Models\AdminUsers::find($userId);

        if (null === $adminUser) {
            return response()->json([
                'success' => false,
                'status' => 'admin_user_not_found',
                'message' => '',
                'data' => []
            ]);
        }

        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'message' => '',
            'data' => self::getAllModules($userId),
        ]);
    }

    private static function getAdminUsersSubmenus ($menus)
    {
        $menusArray = [];
        foreach ($menus as $menu) {

            $adminUserMenu = \App\Models\AdminUserMenu::where('menu_id', $menu->id)->first();

            if (null === $menu->parent_menu_id) {
                continue;
            }

            if (false === isset($adminUserMenu->id)) {
                continue;
            }

            array_push($menusArray, [
                'menu_id' => $menu->id,
                'parent_menu_id' => $menu->parent_menu_id,
                'name' => $menu->name,
                'icon' => $menu->icon,
                'route' => $menu->route
            ]);
        }

        return $menusArray;
    }

    private static function getAdminUserMenus ($menus)
    {
        $menusArray = [];
        foreach ($menus as $menu) {

            $adminUserMenu = \App\Models\AdminUserMenu::where('menu_id', $menu->id)->first();

            if (false === isset($adminUserMenu->id)) {
                continue;
            }

            array_push($menusArray, [
                'menu_id' => $menu->id,
                'parent_menu_id' => $menu->parent_menu_id,
                'name' => $menu->name,
                'icon' => $menu->icon,
                'route' => $menu->route
            ]);
        }

        return $menusArray;
    }

    private static function getAllModules($userId)
    {
        $allModulesArray = [];
        
        $adminUserModules = \App\Models\AdminUserModule::where('admin_user_id', $userId)->get();

        foreach ($adminUserModules as $aum) {
            $module = Module::find($aum->module_id);

            $menus = \App\Models\Menu::where('module_id', $aum->module_id)->get();

            array_push($allModulesArray, [
                'module_id' => $module->id,
                'module_name' => $module->name,
                'menus' => self::getAdminUserMenus($menus),
                'submenus' => self::getAdminUsersSubmenus($menus)
            ]);
        }

        return $allModulesArray;
    }
}
