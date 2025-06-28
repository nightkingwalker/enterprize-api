<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->enum('type', ['task_assigned', 'comment', 'deadline', 'system', 'delivery']);
            $table->unsignedBigInteger('related_id');
            $table->string('related_type');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'read_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
