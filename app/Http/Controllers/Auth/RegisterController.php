<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\Major;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    public function __construct()
    {
        $rol = config('role.admin');
        $this->middleware('auth');
        $this->middleware("role:{$rol}");
    }
    public function showRegistrationForm()
    {
        $roles = Role::all();
        $majors = Major::all();
        return view('auth.register', compact('roles', 'majors'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function register(StoreUserRequest $request)
    {
        $data = $request->validated();
        $major = Major::firstWhere('name', $data['major']);
        $user = User::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $major->users()->save($user);
        $user->assignRole($data['role']);

        return redirect()->route('users.index')->with('alert', [
            'message' => "Usuario $user->name $user->surname creado correctamente.",
            'type' => 'success'
        ]);
    }
}
