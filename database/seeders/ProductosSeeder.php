<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Productos;
use Illuminate\Support\Facades\DB;

class ProductosSeeder extends Seeder
{
    /**
     * Ejecuta el seeder.
     */
    public function run(): void
    {
        //Desactivar comprobaciones de claves foráneas temporalmente
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        //Limpiar tabla antes de insertar
        DB::table('productos')->truncate();
        
        //Array de productos a insertar
        $productos = [
            [
                'nombre' => 'Ramo de Rosas Rojas',
                'descripcion' => 'Hermoso ramo de rosas rojas, perfecto para ocasiones especiales.',
                'precio' => 29.99,
                'stock' => 50,
                'categoria_id' => 1,
                'rutaImg' => 'storage/productos/rosa.png',
                'visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Rosa Individual',
                'descripcion' => 'Elegante rosa roja individual, ideal para detalles románticos.',
                'precio' => 4.99,
                'stock' => 100,
                'categoria_id' => 1,
                'rutaImg' => 'storage/productos/rosaU.png',
                'visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Cactus Decorativo',
                'descripcion' => 'Cactus pequeño decorativo, requiere poco mantenimiento.',
                'precio' => 12.99,
                'stock' => 80,
                'categoria_id' => 2,
                'rutaImg' => 'storage/productos/cactus.png',
                'visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Ramo de Calas Blancas',
                'descripcion' => 'Ramo de calas blancas, elegante y delicado.',
                'precio' => 35.50,
                'stock' => 40,
                'categoria_id' => 1,
                'rutaImg' => 'storage/productos/calaveles.png',
                'visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Ramo de Claveles',
                'descripcion' => 'Colorido ramo de claveles rojos en jarrón.',
                'precio' => 24.50,
                'stock' => 35,
                'categoria_id' => 1,
                'rutaImg' => 'storage/productos/Claveles.jpg',
                'visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Gardenias Blancas',
                'descripcion' => 'Gardenias blancas de aroma intenso y elegante.',
                'precio' => 19.99,
                'stock' => 30,
                'categoria_id' => 1,
                'rutaImg' => 'storage/productos/Gardenias.png',
                'visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Gerberas de Color',
                'descripcion' => 'Gerberas de colores vivos en maceta decorativa.',
                'precio' => 16.50,
                'stock' => 45,
                'categoria_id' => 1,
                'rutaImg' => 'storage/productos/gerberas.png',
                'visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Hortensias Azules',
                'descripcion' => 'Arreglo de hortensias azules, ideal para decoración del hogar.',
                'precio' => 27.99,
                'stock' => 25,
                'categoria_id' => 1,
                'rutaImg' => 'storage/productos/hortensias.png',
                'visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Lirios Blancos',
                'descripcion' => 'Elegantes lirios blancos en ramo, perfectos para celebraciones.',
                'precio' => 32.99,
                'stock' => 30,
                'categoria_id' => 1,
                'rutaImg' => 'storage/productos/lirios.png',
                'visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Lisianthus Púrpura',
                'descripcion' => 'Delicado lisianthus púrpura en maceta decorativa.',
                'precio' => 18.50,
                'stock' => 35,
                'categoria_id' => 2,
                'rutaImg' => 'storage/productos/Lisianthus.png',
                'visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Ramo de Margaritas',
                'descripcion' => 'Fresco ramo de margaritas blancas, ideal para alegrar cualquier ambiente.',
                'precio' => 22.99,
                'stock' => 40,
                'categoria_id' => 1,
                'rutaImg' => 'storage/productos/Margaritas.png',
                'visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Orquídea Blanca',
                'descripcion' => 'Elegante orquídea blanca, símbolo de pureza y elegancia.',
                'precio' => 45.99,
                'stock' => 20,
                'categoria_id' => 2,
                'rutaImg' => 'storage/productos/Orquideas.png',
                'visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Peonía Rosa',
                'descripcion' => 'Hermosa peonía rosa, perfecta para decoración del hogar.',
                'precio' => 28.99,
                'stock' => 30,
                'categoria_id' => 1,
                'rutaImg' => 'storage/productos/peonia.png',
                'visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Potus Verde',
                'descripcion' => 'Planta de interior potus verde, ideal para purificar ambientes.',
                'precio' => 15.99,
                'stock' => 50,
                'categoria_id' => 2,
                'rutaImg' => 'storage/productos/potus.png',
                'visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Astromelias de Color',
                'descripcion' => 'Colorido ramo de astromelias, duraderas y elegantes.',
                'precio' => 26.50,
                'stock' => 35,
                'categoria_id' => 1,
                'rutaImg' => 'storage/productos/astromeiras.png',
                'visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Sansevieria',
                'descripcion' => 'Planta resistente de interior, perfecta para principiantes.',
                'precio' => 17.99,
                'stock' => 45,
                'categoria_id' => 2,
                'rutaImg' => 'storage/productos/Sansevieria.png',
                'visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        //Inserción masiva
        DB::table('productos')->insert($productos);
        
        //Reactivar comprobaciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}