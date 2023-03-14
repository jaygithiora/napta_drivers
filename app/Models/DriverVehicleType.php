<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverVehicleType extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'driver_id', 'vehicle_type_id','status'];

    public function driver(){
        return $this->belongsTo(Driver::class);
    }
    public function vehicle_type(){
        return $this->belongsTo(VehicleType::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
