<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = Admin::create([
            'name' => 'Admin', 
            'email' => 'admin@gmail.com',
            'status' => 1,
            'password' => bcrypt('123456')
        ]);

        // echo "<pre>"; print_r($user);die;
    
        $role = Role::create(['guard_name' => 'admin','name' => 'Admin']);
     
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        
        // echo "<pre>"; print_r($role->id);die;
        $user->assignRole([$role->id]);
    }
}
