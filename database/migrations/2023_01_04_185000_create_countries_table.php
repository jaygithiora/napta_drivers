<?php

use App\Models\Country;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string("name")->unique();
            $table->string("country_code")->unique();
            $table->string("phone_code")->unique();
            $table->boolean("status")->default(true);
            $table->timestamps();
        });
        $country = new Country;
        $country->name = "Kenya";
        $country->country_code = "KE";
        $country->phone_code = "254";
        $country->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
};
