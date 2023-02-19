<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
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
        $role = Role::where('name', 'Super Admin')->first();
        $country = Country::where('name', 'Kenya')->first();
        if($role != null && $country != null){
            $user = new User;
            $user->firstname = "James";
            $user->lastname = "Githiora";
            $user->email = "jaygithiora@gmail.com";
            $user->phone = "0791162496";
            $user->password = Hash::make("12345");
            $user->country_id = $country->id;
            $user->save();
        }
    }
}
