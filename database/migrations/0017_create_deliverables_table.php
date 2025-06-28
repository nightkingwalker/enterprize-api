<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('deliverables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('task_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('file_id')->constrained('project_files')->onDelete('cascade');
            $table->foreignId('delivered_to')->constrained('client_employees')->onDelete('restrict');
            $table->foreignId('delivered_by')->constrained('users')->onDelete('restrict');
            $table->enum('delivery_method', ['email', 'platform', 'whatsapp', 'ftp', 'other']);
            $table->timestamp('delivery_date')->useCurrent();
            $table->boolean('read_confirmation')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('deliverables');
    }
};
