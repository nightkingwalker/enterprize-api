<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('project_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->string('original_name');
            $table->string('storage_path');
            $table->enum('file_type', ['docx', 'pdf', 'xlsx', 'pptx', 'txt', 'html', 'json', 'xml', 'other']);
            $table->integer('word_count')->default(0);
            $table->integer('pages')->nullable();
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('restrict');
            $table->timestamp('uploaded_at')->useCurrent();
            $table->enum('status', ['uploaded', 'processing', 'ready', 'error'])->default('uploaded');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_files');
    }
};
