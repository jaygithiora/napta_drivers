<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    use HasFactory;

    protected $fillable = ["name", "description", "required", "status"];

    public function document_uploads(){
        return $this->hasMany(DocumentUpload::class);
    }
}
