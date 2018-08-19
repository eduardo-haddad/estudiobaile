<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_usuario = Role::where('name', 'usuario')->first();
        $role_administrador  = Role::where('name', 'administrador')->first();
        $admin = new User();
        $admin->name = 'Eduardo Haddad';
        $admin->username = 'eduardo';
        $admin->email = 'eduardo.torquemada@gmail.com';
        $admin->password = bcrypt('haddad');
        $admin->save();
        $admin->roles()->attach($role_administrador);
        $usuario = new User();
        $usuario->name = 'Usuário';
        $usuario->username = 'usuario';
        $usuario->email = 'usuario@example.com';
        $usuario->password = bcrypt('usuario');
        $usuario->save();
        $usuario->roles()->attach($role_usuario);
      }
}
