<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::paginate(6);
        return view('users.role', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:roles'
        ], [], [
            'name' => 'nombre'
        ]);

        $rol = Role::create([
            'name' => $data['name'],
        ]);

        return redirect()->route('roles.index')->with('alert', [
            'message' => "Rol $rol->name creado correctamente.",
            'type' => 'success'
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name-update' => 'required|string|max:255|unique:majors,name'
        ], [], [
            'name-update' => 'nombre'
        ]);
        $role->update(['name' => $data['name-update']]);

        return redirect()->route('roles.index')->with('alert', [
            'message' => "Rol $role->name actualizado correctamente.",
            'type' => 'success'
        ]);
    }


    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')->with('alert', [
            'message' => "Rol $role->name eliminada correctamente.",
            'type' => 'success'
        ]);
    }
}
