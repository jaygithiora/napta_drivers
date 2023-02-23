<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverApproval extends Model
{
    use HasFactory;
    protected $fillable = ["driver_id","user_id","comments",'status'];

    public function driver(){
        return $this->belongsTo(Driver::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
