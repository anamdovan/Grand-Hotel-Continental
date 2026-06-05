<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TablaRolesSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('roles')->insert([
            ['tipoRol' => 'admin',         'created_at' => now(), 'updated_at' => now()],
            ['tipoRol' => 'recepcionista', 'created_at' => now(), 'updated_at' => now()],
            ['tipoRol' => 'cliente',       'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
