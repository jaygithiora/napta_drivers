<?php

use App\Models\Country;
use App\Models\User;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use App\Models\VehicleOwner;
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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string("plate")->unique();
            $table->string("engine_number")->unique();
            $table->string("chasis_number")->unique();
            $table->date("registration_date");
            $table->date("expiry_date")->nullable();
            $table->foreignIdFor(VehicleOwner::class)->nullable();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(VehicleMake::class);
            $table->foreignIdFor(VehicleModel::class);
            $table->foreignIdFor(Country::class);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
};
