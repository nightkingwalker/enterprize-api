<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('segment_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('segment_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('action', ['created', 'translated', 'edited', 'approved', 'rejected']);
            $table->text('content_before')->nullable();
            $table->text('content_after');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('segment_history');
    }
};
