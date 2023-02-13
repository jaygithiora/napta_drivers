<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentUpload extends Model
{
    use HasFactory;
    protected $fillable = ["name", "upload_name", "user_id", "document_type_id", "status"];

    public function document_type(){
        return $this->belongsTo(DocumentType::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
