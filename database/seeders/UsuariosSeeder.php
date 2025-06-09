<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuarios;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    /**
     * Ejecuta el seeder.
     */
    public function run(): void
    {
        //Desactivar comprobaciones de claves foráneas temporalmente
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        //Limpiar tabla antes de insertar
        DB::table('usuarios')->truncate();
        
        //Array de usuarios a insertar
        $usuarios = [
            [
                'username' => 'admin',
                'email' => 'admin@larabloom.com',
                'password' => Hash::make('Admin1234@'),
                'admin' => true,
                'newsletter' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'usuario1',
                'email' => 'usuario@gmail.com',
                'password' => Hash::make('Usuario1234@'),
                'admin' => false,
                'newsletter' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'usuario2',
                'email' => 'usuario2@gmail.com',
                'password' => Hash::make('Usuario1234@'),
                'admin' => false,
                'newsletter' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        //Inserción masiva
        DB::table('usuarios')->insert($usuarios);
        
        //Reactivar comprobaciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}