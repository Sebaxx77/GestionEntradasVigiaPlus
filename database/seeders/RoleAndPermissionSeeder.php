<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        /*
         * Definir permisos por módulos:
         */

        // Permisos para el módulo de Permisos
        Permission::create(['name' => 'Administrar Permisos']);

        // Permisos para el módulo de Roles
        Permission::create(['name' => 'Administrar Roles']);

        // Permisos para el módulo de Usuarios
        Permission::create(['name' => 'Administrar Usuarios']);

        // Permisos para el módulo de Operaciones
        Permission::create(['name' => 'Administrar Operaciones']);

        // Permisos para el módulo de Parques Industriales
        Permission::create(['name'=> 'Administrar Parques Industriales']);

        // Permisos para el módulo de Correos Notificables por Operación
        Permission::create(['name'=> 'Administrar Correos Notificables']);

        // Permisos para el modulo de Agendamientos Descarga
        Permission::create(['name' => 'Gestionar Agendamientos Descarga']);

        Permission::create(['name'=> 'Supervisar Agendamientos Descarga']);

        // Permisos para el módulo de Agendamiento Visitas
        Permission::create(['name'=> 'Gestionar Agendamientos Visitas']);

        /*
         * Crear roles y asignar permisos:
         */

        // Rol Administrador: acceso a todos los permisos
        $admin = Role::create(['name' => 'Administrador']);
        $admin->givePermissionTo(Permission::all());

        // Rol Autorizador: acceso a gestionar agendamientos (aprobar/rechazar)
        $autorizador = Role::create(['name' => 'Autorizador Agendamientos']);
        $autorizador->givePermissionTo([
            // Agendamientos
            'Gestionar Agendamientos Descarga',
            'Supervisar Agendamientos Descarga',
        ]);

        // Rol Supervisor Agendamientos: acceso a agendamientos (visualizacion de agendamientos y detalles)
        $autorizador = Role::create(['name' => 'Supervisor Agendamientos']);
        $autorizador->givePermissionTo([
            // Agendamientos
            'Supervisar Agendamientos Descarga',
        ]);
    }
}
