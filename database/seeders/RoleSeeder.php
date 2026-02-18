<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'Sales Rep',
            'BDC Agent',
            'F&I',
            'Sales Manager',
            'BDC Manager',
            'Finance Director',
            'General Sales Manager',
            'General Manager',
            'Dealer Principal',
            'Admin',
            'Reception',
            'Service Advisor',
            'Service Manager',
            'Inventory Manager',
            'Fixed Operations Manager',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $this->command->info('Roles created successfully!');
    }
}
