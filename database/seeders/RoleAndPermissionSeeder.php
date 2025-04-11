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
        $guard = 'sanctum'; // <--- Aseguramos que todo se registre con este guard

        /*
         * Definir permisos por módulos:
         */
        $permisos = [
            'Administrar Permisos',
            'Administrar Roles',
            'Administrar Usuarios',
            'Administrar Operaciones',
            'Administrar Parques Industriales',
            'Administrar Correos Notificables',
            'Gestionar Agendamientos Descarga',
            'Supervisar Agendamientos Descarga',
            'Gestionar Agendamientos Visitas',
        ];

        foreach ($permisos as $permiso) {
            Permission::create(['name' => $permiso, 'guard_name' => $guard]);
        }

        /*
         * Crear roles y asignar permisos:
         */

        // Rol Administrador: acceso a todos los permisos
        $admin = Role::create(['name' => 'Administrador', 'guard_name' => $guard]);
        $admin->givePermissionTo(Permission::all());

        // Rol Autorizador: acceso a gestionar agendamientos (aprobar/rechazar)
        $autorizador = Role::create(['name' => 'Autorizador Agendamientos', 'guard_name' => $guard]);
        $autorizador->givePermissionTo([
            'Gestionar Agendamientos Descarga',
            'Supervisar Agendamientos Descarga',
        ]);

        // Rol Supervisor Agendamientos
        $supervisor = Role::create(['name' => 'Supervisor Agendamientos', 'guard_name' => $guard]);
        $supervisor->givePermissionTo([
            'Supervisar Agendamientos Descarga',
        ]);
    }
}
