<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $fillable = ["plate","engine_number","chasis_number","registration_date", "expiry_date", 
    "vehicle_owner_id", "user_id", "vehicle_make_id",	"vehicle_model_id","country_id","status"];
    public function vehicle_model(){
        return $this->belongsTo(VehicleModel::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
