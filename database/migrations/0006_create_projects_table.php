<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requested_by')->constrained('client_employees')->onDelete('restrict');
            $table->foreignId('project_manager_id')->constrained('users')->onDelete('restrict');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('source_language');
            $table->json('target_languages');
            $table->dateTime('deadline');
            $table->enum('status', ['pending', 'in_progress', 'review', 'completed', 'delivered', 'archived'])->default('pending');
            $table->integer('word_count')->default(0);
            $table->decimal('price', 12, 2)->nullable();
            $table->string('currency', 3)->default('USD');
            $table->text('instructions')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
