<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CreateMissingRolesSeeder extends Seeder
{
    public function run()
    {
        $roles = ['Teacher', 'Student', 'Parent', 'School Admin'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }
    }
}
