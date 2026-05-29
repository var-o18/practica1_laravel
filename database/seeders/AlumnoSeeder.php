<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AlumnoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('alumno')->insert([
            [
                'nombre' => 'Ana Man0lo',
                'telefono' => '600111222',
                'edad' => 20,
                'password' => Hash::make('secreto1'),
                'email' => 'ana@ejemplo.com',
                'sexo' => 'F',
            ],
            [
                'nombre' => 'Luis Martínez',
                'telefono' => null,
                'edad' => 22,
                'password' => Hash::make('secreto2'),
                'email' => 'luis@ejemplo.com',
                'sexo' => 'M',
            ],
            [
                'nombre' => 'María López',
                'telefono' => null,
                'edad' => null,
                'password' => Hash::make('secreto3'),
                'email' => 'maria@ejemplo.com',
                'sexo' => 'F',
            ],
        ]);
    }
}
