<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_usuario = new Role();
        $role_usuario->name = 'usuario';
        $role_usuario->description = 'Usuário';
        $role_usuario->save();
        $role_usuario = new Role();
        $role_usuario->name = 'equipe';
        $role_usuario->description = 'Equipe';
        $role_usuario->save();
        $role_administrador = new Role();
        $role_administrador->name = 'administrador';
        $role_administrador->description = 'Administrador';
        $role_administrador->save();
        $role_superadmin = new Role();
        $role_superadmin->name = 'superadmin';
        $role_superadmin->description = 'Superadmin';
        $role_superadmin->save();
    }
}
