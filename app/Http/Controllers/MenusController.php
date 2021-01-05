<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Menu;
use App\Models\Module;
use Illuminate\Http\Request;

class MenusController extends Controller
{
    public function store (Request $request)
    {
        $parentMenuId  =   $request->input('parent_menu_id');
        $moduleId      =   $request->input('module_id');
        $name          =   $request->input('name');
        $icon          =   $request->input('icon');
        $route         =   $request->input('route');

        if (null === $moduleId) {
            return response()->json([
                'success'  => false,
                'status'   => 'invalid_nodule_id',
                'message' => 'ID do Módulo não informado.',
                'data' => [],
            ]);            
        }

        if (null === $name) {
            return response()->json([
                'success'  => false,
                'status'   => 'invalid_menu_name',
                'message' =>  'Nome do menu não informado.',
                'data' => [],
            ]);            
        }

        if (null === $icon) {
            return response()->json([
                'success'  => false,
                'status'   => 'invalid_menu_icon',
                'message' =>  'Ícone não informado.',
                'data' => [],
            ]);            
        }

        if (null === $route) {
            return response()->json([
                'success'  => false,
                'status'   => 'invalid_menu_route',
                'message' =>  'Rota não informada.',
                'data' => [],
            ]);            
        }

        try {

            $menu = new Menu();
            $menu->parent_menu_id =  $parentMenuId;
            $menu->module_id      =  $moduleId;
            $menu->name           =  $name;
            $menu->icon           =  $icon;
            $menu->route          =  $route;
            $menu->save();

        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'success'  => false,
                'status'   => 'unkdown_error',
                'message' => 'Ocorreu um erro desconhecido. Contate o administrador da plataforma.',
                'data' => [],
            ]);
        }

        return response()->json([
            'success'  => false,
            'status'   => 'success',
            'message' =>  'Menu cadastrado com sucesso.',
            'data' => $menu,
        ]);
    }

    public function listMenus()
    {
        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'message' => '',
            'data' => Menu::all(),
        ]);
    }

    public function edit(Request $request, $id)
    {
        $parentMenuId = $request->input('parent_menu_id') ??    null;
        $moduleId     = $request->input('module_id')      ??    null;
        $name         = $request->input('name')           ??    null;
        $icon         = $request->input('icon')           ??    null;
        $route        = $request->input('route')          ??    null;

        $module = Module::find($moduleId);

        if (null === $moduleId || null === $module) {
            return response()->json([
                'success' => false,
                'status' => 'invalid_menu_module_id',
                'message' => 'É necessário informar o módulo.',
                'data' => [],
            ]);
        }

        if (null === $name) {
            return response()->json([
                'success' => false,
                'status' => 'invalid_menu_name',
                'message' => 'É necessário informar o nome do menu.',
                'data' => [],
            ]);
        }

        if (null === $icon) {
            return response()->json([
                'success' => false,
                'status' => 'invalid_menu_icon',
                'message' => 'É necessário informar a ícone do menu.',
                'data' => [],
            ]);
        }

        if (null === $route) {
            return response()->json([
                'success' => false,
                'status' => 'invalid_menu_route',
                'message' => 'É necessário informar a rota do menu.',
                'data' => [],
            ]);
        }

        $menu = Menu::find($id);
        $menu->parent_menu_id = $parentMenuId;
        $menu->module_id = $moduleId;
        $menu->name = $name;
        $menu->icon = $icon;
        $menu->route = $route;
        $menu->save();

        return response()->json([
            'success' => true,
            'status' => 'success',
            'message' => 'Menu alterado com sucesso.',
            'data' => $menu,
        ]);

    }

    public function getById ($id)
    {
        $menu = Menu::find($id);

        if (null === $menu) {
            return response()->json([
                'success' => false,
                'status' => 'menu_not_found',
                'message' => 'Menu não encontrado.',
                'data' => [],
            ]);
        }

        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'message' => '',
            'data' => $menu,
        ]); 
    }

    public function destroy($id)
    {
        $menu = Menu::find($id);

        if (null === $menu) {
            return response()->json([
                'success' => false,
                'status' => 'menu_not_found',
                'message' => 'Menu não encontrado.',
                'data' => [],
            ]);
        }

        $secondaryMenus = Menu::where('parent_menu_id', $id)->first();

        if (isset($secondaryMenus->id)) {
            return response()->json([
                'success' => false,
                'status' => 'parent_other_menus',
                'message' => 'Existem menus abaixo deste. Por favor, altere-os e tente excluir novamente.',
                'data' => [],
            ]);
        }
        
        $menu->delete();

        return response()->json([
            'success'  => true,
            'status'   => 'success',
            'message' => '',
            'data' => [],
        ]);         
    }
}
