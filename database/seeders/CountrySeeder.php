<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Http\Controllers\Shared\Helper;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'countries';
        $file = base_path("database/data/$table" . ".csv");
        $records = Helper::import_CSV($file);

        foreach ($records as $key => $record) {
           Country::updateOrCreate(
                ['name' => $record['name']],  // columns to search for
                [   // data to update or insert
                    'name' => $record['name'],
                    'country_code'=> $record['country_code'],
                    'phone_code'=> $record['phone_code'],
                ]
            );
        }
    }
}
