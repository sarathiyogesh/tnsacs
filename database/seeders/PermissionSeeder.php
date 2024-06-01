<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Module
        $input = [
            ['name' => 'role-add', 'guard_name' => 'web'],
            ['name' => 'role-view', 'guard_name' => 'web'],
            ['name' => 'role-edit', 'guard_name' => 'web'],
        ];
        foreach($input as $data){
            Permission::create($data);
        }
        $role = Role::create(['name' => 'Super Admin']);
        //Role 
        $role = Role::find(1);
        
        //Create user
        $user = User::find(1);

        //Assign Role
        $permissions = Permission::pluck('id','id')->all();
  
        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);

    }
}
