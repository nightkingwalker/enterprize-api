<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('file_id')->constrained('project_files')->onDelete('cascade');
            $table->foreignId('requested_by')->constrained('client_employees')->onDelete('restrict');
            $table->foreignId('assignee_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('reviewer_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('source_language');
            $table->string('target_language');
            $table->integer('segment_count')->default(0);
            $table->integer('word_count')->default(0);
            $table->enum('status', ['not_started', 'in_progress', 'submitted', 'in_review', 'completed', 'rejected'])->default('not_started');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->dateTime('deadline');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
