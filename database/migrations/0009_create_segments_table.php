<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('segments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->text('original_text');
            $table->text('translated_text')->nullable();
            $table->integer('segment_number');
            $table->enum('status', ['not_started', 'in_progress', 'translated', 'reviewed', 'approved'])->default('not_started');
            $table->integer('word_count')->default(0);
            $table->integer('char_count')->default(0);
            $table->boolean('is_repeated')->default(false);
            $table->foreignId('repeat_of')->nullable()->constrained('segments')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('segments');
    }
};
