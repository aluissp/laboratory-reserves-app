<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Creando roles por defecto
        $role = Role::create(['name' => 'administrador']);
        Role::create(['name' => 'estudiante']);

        // Creando el usuario administrador
        User::create([
            'name' => 'Luis',
            'surname' => 'Perugachi',
            'email' => 'laperugachic@utn.edu.ec',
            'password' => Hash::make('test1234'),
            'role_id' => $role->id
        ]);
    }
}
