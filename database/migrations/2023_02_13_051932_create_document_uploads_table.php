<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\DocumentType;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_uploads', function (Blueprint $table) {
            $table->id();
            $table->string("name")->unique();
            $table->string("upload_name");
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(DocumentType::class);
            $table->unsignedInteger("status")->default(0);
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
        Schema::dropIfExists('document_uploads');
    }
};
