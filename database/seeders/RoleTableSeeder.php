<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Super Admin'
        ]);

        Role::create([
            'name' => 'Manager'
        ]);

        Role::create([
            'name' => 'Employee'
        ]);
    }
}
