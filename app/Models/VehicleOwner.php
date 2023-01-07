<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleOwner extends Model
{
    use HasFactory;
    protected $fillable = ["firstname", "lastname", "id_number", "id_issuance_date", "id_expiry_date", "contact_number", "address"];
}
