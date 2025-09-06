<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        Usuario::create([
            'nombre' => 'Admin',
            'apellido' => 'Principal',
            'correo' => 'admin@admin.com',
            'password' => 'admin123', // 🔐 contraseña segura
            'cargo' => 'admin',
            'inhabilitado' => false,
        ]);
    }
}
