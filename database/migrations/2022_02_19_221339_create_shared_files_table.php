<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharedFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shared_files', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->uuid('file_uuid');
            $table->uuid('shared_with');
            $table->timestamps();
            // $table->foreignId('file_id')->constrained('files')->cascadeOnUpdate()->cascadeOnDelete();
            // $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('file_uuid')->references('uuid')->on('files')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('shared_with')->references('uuid')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shared_files');
    }
}
