<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

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
        Role::create(['name' => config('role.admin')]);
        Role::create(['name' => 'estudiante']);


        // Creando el usuario administrador
        $user = User::create([
            'name' => 'Luis',
            'surname' => 'Perugachi',
            'email' => 'laperugachic@utn.edu.ec',
            'password' => Hash::make('test1234')
        ]);

        $user2 = User::create([
            'name' => 'Maite',
            'surname' => 'Perugachi',
            'email' => 'maite@utn.edu.ec',
            'password' => Hash::make('test1234')
        ]);

        $user->assignRole(config('role.admin'));
        $user2->assignRole('estudiante');
    }
}
