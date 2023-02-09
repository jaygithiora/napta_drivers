<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class DocumentTypeRole extends Model
{
    use HasFactory;
    protected $fillable = ["role_id", "document_type_id"];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function document_type()
    {
        return $this->belongsTo(DocumentType::class);
    }
}