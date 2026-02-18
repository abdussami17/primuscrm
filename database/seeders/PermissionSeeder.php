<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define all permissions exactly as they appear in add-user.blade.php
        $permissions = [
            // Lead & Customer Management
            'View All Dealer Deals/Customer Info',
            'Edit All Dealer Deals/Customer Info',
            'Reassign Deals',
            'Merge Deals',
            'Duplicate Deals',
            'Delete Deals',
            'Delete Customer',

            // Tasks, Notes & Communication
            'Create Tasks',
            'Edit Tasks',
            'Delete Tasks',
            'Assign Tasks',
            'Send Text',
            'Send Email',

            // Privacy, Legal & Compliance
            'View CASL Opt-In Status',
            'Edit CASL Opt-In Status',
            'Mark Customers As "Do Not Contact"',
            'Edit "Do Not Contact" Status',
            'Export Notes',
            'Export Task / Appointment',

            // Group-Level Controls
            'Access All Rooftops',
            'Group-Wide Reporting',

            // Appointments & Calendar
            'Create Own Appointments',
            'Edit Own Appointments',
            'Delete Own Appointments',
            'Create Appointments For Others',
            'Edit Appointments For Others',
            'Delete Appointments For Others',
            'Access Calendar',

            // Sales Pipeline
            'Post To DMS',
            'Mark Deal As Sold',
            'Mark Deal As Delivered',
            'Reopen Deal',
            'Add Showroom Visit',
            'Delete Showroom Visit',

            // Reports & Analytics
            'Access Reports & Analytics',
            'Ability To Print And Export Reports',
            'Schedule Reports',
            'Delete Schedule Reports',

            // CRM Configuration
            'Access To Users',
            'Reset Password',
            'Impersonate Users',
            'Email Required On Lead Creation',
            'Cell Phone Number Required On Lead Creation',
            'Work Number Required On Lead Creation',
            'Phone Number Required On Lead Creation',
            'Full Name Required On Lead Creation',
            'Last Name Required On Lead Creation',
            'Source Required On Lead Creation',
            'Ability To Export / Print',
            'Access To Manager\'s Desk Log',
            'Access To Showroom',
            'Access To Smart Sequences',
            'Access To Campaigns & Templates',
            'Access To Dealership Settings',

            // Campaigns & Smart Sequences
            'Access To Campaigns',
            'Access To Smart Sequence',
            'Edit Smart Sequences',
            'Delete Smart Sequences',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $this->command->info('Permissions created successfully!');

        // Assign all permissions to Admin role
        $adminRole = Role::where('name', 'Admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo(Permission::all());
            $this->command->info('All permissions assigned to Admin role!');
        }
    }
}
