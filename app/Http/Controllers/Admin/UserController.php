<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\Major;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $majors = Major::all();
        return view('users.edit', compact('user', 'roles', 'majors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUserRequest $request, User $user)
    {
        $data = $request->validated();
        $major = Major::firstWhere('name', $data['major']);
        $data['password'] = Hash::make($data['password']);
        $user->update($data);
        $major->users()->save($user);
        $user->removeRole($user->roles?->first()->name);
        $user->assignRole($data['role']);

        return redirect()->route('users.index')->with('alert', [
            'message' => "Usuario $user->name $user->surname actualizado correctamente.",
            'type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('alert', [
            'message' => "Usuario $user->name $user->surname eliminado correctamente.",
            'type' => 'success'
        ]);
    }

    public function filter($filter)
    {
        if ($filter == 'all') {
            $data = User::get();
        } else {
            $data = User::where('name', 'like', "%$filter%")
                ->orWhere('surname', 'like', "%$filter%")
                ->limit(6)
                ->get();
        }

        foreach ($data as $user) {
            $user['roles'] = $user->roles?->first()->name;
            $user['major'] = $user->major?->name;
        }

        return response()->json([
            'response' => $data,
            'message' => 'Datos obtenidos correctamente.'
        ], 200);
    }
}
