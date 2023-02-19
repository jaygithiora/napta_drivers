<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => "Super Admin",
            'can_register'=>false,
        ]);
        Role::create([
            'name' => "User",
            'can_register'=>true,
        ]);
        Role::create([
            'name' => "Driver",
            'can_register'=>true,
        ]);
        $this->call([
            CountrySeeder::class,
            UserSeeder::class,
        ]);
    }
}
