<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    use HasFactory;
    protected $fillable = ["name", "vehicle_make_id", "status"];

    public function vehicle_make(){
        return $this->belongsTo(VehicleMake::class);
    }
}
