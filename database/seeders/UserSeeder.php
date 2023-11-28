<?php

namespace Database\Seeders;

use App\Http\Controllers\Shared\Helper;
use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'users';
        $file = base_path("database/data/$table" . ".csv");
        $records = Helper::import_CSV($file);

        foreach ($records as $key => $record) {
           $user = User::updateOrCreate(
                ['email' => $record['email']],  // columns to search for
                [   // data to update or insert
                    'firstname'=> $record['firstname'],
                    'lastname'=> $record['lastname'],
                    'email' => $record['email'],
                    'phone' => $record['phone'],
                    'password' => $record['password'],
                    'country_id' => $record['country_id'],
                ]
            );
            $role = Role::where('name', 'Super Admin')->first();
            $user->assignRole($role);
        }
    }
}
