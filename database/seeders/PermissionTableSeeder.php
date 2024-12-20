<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
  
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
           'role-list',
           'role-create',
           'role-edit',
           'role-delete',
           'project-list',
           'project-create',
           'project-edit',
           'project-delete',
           'users-list',
           'users-create',
           'users-edit',
           'users-delete',
           'cc-traceability',
           'ghe-traceability',
           'carbon-credit-trading',
           'reporting-analytics',
           'communication-notifications',
           'master-database',
           'master-dashboard',
        ];
        
        foreach ($permissions as $permission) {
             Permission::create(['guard_name' => 'admin','name' => $permission]);
        }
    }
}