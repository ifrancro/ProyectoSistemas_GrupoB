<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EleccionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insertar usuario admin
        DB::table('usuarios')->insert([
            'username' => 'admin',
            'password_hash' => Hash::make('admin123'),
            'rol' => 'ADMIN',
            'creado_en' => now()
        ]);

        // Insertar departamentos
        DB::table('departamentos')->insert([
            ['nombre' => 'Santa Cruz'],
            ['nombre' => 'Cochabamba'],
            ['nombre' => 'La Paz']
        ]);

        // Insertar provincias
        DB::table('provincias')->insert([
            ['nombre' => 'Andrés Ibáñez', 'id_departamento' => 1],
            ['nombre' => 'Warnes', 'id_departamento' => 1],
            ['nombre' => 'Cercado', 'id_departamento' => 2],
            ['nombre' => 'Quillacollo', 'id_departamento' => 2]
        ]);

        // Insertar municipios
        DB::table('municipios')->insert([
            ['nombre' => 'Santa Cruz de la Sierra', 'id_provincia' => 1],
            ['nombre' => 'Warnes', 'id_provincia' => 2],
            ['nombre' => 'Cochabamba', 'id_provincia' => 3],
            ['nombre' => 'Quillacollo', 'id_provincia' => 4]
        ]);

        // Insertar asientos
        DB::table('asientos')->insert([
            ['nombre' => 'Centro', 'id_municipio' => 1],
            ['nombre' => 'Norte', 'id_municipio' => 1],
            ['nombre' => 'Sur', 'id_municipio' => 1]
        ]);

        // Insertar recintos
        DB::table('recintos')->insert([
            ['nombre' => 'Colegio Nacional Florida', 'direccion' => 'Av. Cañoto', 'id_asiento' => 1],
            ['nombre' => 'Escuela San Martín', 'direccion' => 'Av. Roca y Coronado', 'id_asiento' => 1],
            ['nombre' => 'Unidad Educativa San José', 'direccion' => 'Av. Alemana', 'id_asiento' => 2]
        ]);

        // Insertar mesas
        DB::table('mesas')->insert([
            ['numero' => 1, 'id_recinto' => 1],
            ['numero' => 2, 'id_recinto' => 1],
            ['numero' => 1, 'id_recinto' => 2],
            ['numero' => 1, 'id_recinto' => 3]
        ]);

        // Insertar partidos
        DB::table('partidos')->insert([
            ['sigla' => 'MAS', 'nombre' => 'Movimiento al Socialismo', 'estado' => 'ACTIVO'],
            ['sigla' => 'CC', 'nombre' => 'Comunidad Ciudadana', 'estado' => 'ACTIVO'],
            ['sigla' => 'FPV', 'nombre' => 'Frente Para la Victoria', 'estado' => 'ACTIVO']
        ]);

        // Insertar instituciones
        DB::table('instituciones')->insert([
            ['nombre' => 'Transparencia Ciudadana', 'sigla' => 'TC'],
            ['nombre' => 'Democracia Viva', 'sigla' => 'DV'],
            ['nombre' => 'Observatorio Electoral', 'sigla' => 'OE']
        ]);

        // Insertar personas de prueba
        DB::table('personas')->insert([
            [
                'ci' => '1234567',
                'nombre' => 'Juan',
                'apellido' => 'Pérez',
                'fecha_nacimiento' => '1990-05-15',
                'correo' => 'juan.perez@email.com',
                'telefono' => '70012345',
                'ciudad' => 'Santa Cruz',
                'creado_en' => now()
            ],
            [
                'ci' => '7654321',
                'nombre' => 'María',
                'apellido' => 'Gómez',
                'fecha_nacimiento' => '1985-08-22',
                'correo' => 'maria.gomez@email.com',
                'telefono' => '70054321',
                'ciudad' => 'Cochabamba',
                'creado_en' => now()
            ],
            [
                'ci' => '9876543',
                'nombre' => 'Carlos',
                'apellido' => 'López',
                'fecha_nacimiento' => '1992-12-10',
                'correo' => 'carlos.lopez@email.com',
                'telefono' => '70098765',
                'ciudad' => 'La Paz',
                'creado_en' => now()
            ]
        ]);

        // Insertar jurados de prueba
        DB::table('jurados')->insert([
            [
                'id_persona' => 1,
                'id_mesa' => 1,
                'cargo' => 'PRESIDENTE',
                'verificado' => false
            ],
            [
                'id_persona' => 2,
                'id_mesa' => 1,
                'cargo' => 'SECRETARIO',
                'verificado' => false
            ]
        ]);

        // Insertar veedor de prueba
        DB::table('veedores')->insert([
            [
                'id_persona' => 3,
                'id_institucion' => 1,
                'estado' => 'PENDIENTE'
            ]
        ]);

        // Insertar delegado de prueba
        DB::table('delegados')->insert([
            [
                'id_persona' => 1,
                'id_partido' => 1,
                'id_mesa' => 1,
                'habilitado' => true
            ]
        ]);
    }
}
