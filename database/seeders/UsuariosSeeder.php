<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //creamos el usuario admin con password admin
        $usuario = new User();
        $usuario->name = 'admin';
        $usuario->email = 'admin';
        $usuario->password = bcrypt('admin');
        $usuario->save();
    }
}
