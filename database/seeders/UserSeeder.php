<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        $user = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@primuscrm.com',
        ]);
        
        $user->assignRole('Admin');

        
        $roles = Role::where('name', '!=', 'Admin')->get();

        foreach ($roles as $role) {

            for ($i = 1; $i <= 5; $i++) {

                $user = User::create([
                    'name' => "{$role->name} {$i}",
                    'email' => Str::slug($role->name) . "{$i}@demo.local",
                    'password' => 'password',

                    'title' => $role->name,
                    'employee_number' => strtoupper(Str::random(3)),

                    'work_phone' => fake()->phoneNumber(),
                    'cell_phone' => fake()->phoneNumber(),
                    'home_phone' => fake()->phoneNumber(),

                    'profile_photo' => null,
                    'email_signature' => "Regards,<br>{$role->name}",

                    'working_hours' => [
                        'mon' => '9:00-17:00',
                        'tue' => '9:00-17:00',
                        'wed' => '9:00-17:00',
                        'thu' => '9:00-17:00',
                        'fri' => '9:00-17:00',
                    ],

                    'dealership_franchises' => ['Toyota', 'Mazda'],

                    'is_active' => true,
                    'receive_internet_lead' => true,
                    'receive_off_hours' => false,
                ]);

                $user->assignRole($role->name);
            }
        }

        $this->command->info('Users created: 5 per role (Admin excluded)');
    }
}
