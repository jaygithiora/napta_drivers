<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::create([
            'name'=>'Kenya',
            'country_code'=>'KE',
            'phone_code'=>'254',
            'status'=>true,
        ]);
        Country::create([
            'name'=>'Uganda',
            'country_code'=>'UG',
            'phone_code'=>'256',
            'status'=>true,
        ]);
        Country::create([
            'name'=>'Tanzania',
            'country_code'=>'TZ',
            'phone_code'=>'255',
            'status'=>true,
        ]);
    }
}
