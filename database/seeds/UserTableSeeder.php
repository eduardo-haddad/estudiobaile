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
        $role_equipe  = Role::where('name', 'equipe')->first();
        $role_administrador  = Role::where('name', 'administrador')->first();
        $role_superadmin  = Role::where('name', 'superadmin')->first();
        $tt = new User();
        $tt->name = 'Thereza Farkas';
        $tt->username = 'tfarkas';
        $tt->email = 'thereza@estudiobaile.org';
        $tt->password = bcrypt('Girassol1234');
        $tt->save();
        $tt->roles()->attach($role_superadmin);
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
        $usuario->password = bcrypt('eb-usuario');
        $usuario->save();
        $usuario->roles()->attach($role_usuario);
        $equipe = new User();
        $equipe->name = 'Equipe';
        $equipe->username = 'equipe';
        $equipe->email = 'equipe@example.com';
        $equipe->password = bcrypt('eb-equipe');
        $equipe->save();
        $equipe->roles()->attach($role_equipe);
      }
}
