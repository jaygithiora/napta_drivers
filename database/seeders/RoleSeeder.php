<?php

namespace Database\Seeders;

use App\Http\Controllers\Shared\Helper;
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
        $table = 'roles';
        $file = base_path("database/data/$table" . ".csv");
        $records = Helper::import_CSV($file);

        foreach ($records as $key => $record) {
           Role::updateOrCreate(
                ['name' => $record['name']],  // columns to search for
                [   // data to update or insert
                    'name'=> $record['name'],
                    'can_register' => $record['can_register'],
                ]
            );
        }
    }
}
