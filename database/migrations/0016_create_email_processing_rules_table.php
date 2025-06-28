<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('email_processing_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('integration_id')->constrained('api_integrations')->onDelete('cascade');
            $table->string('subject_pattern');
            $table->string('sender_pattern');
            $table->enum('action', ['create_project', 'notify_only', 'create_task']);
            $table->foreignId('project_template_id')->nullable()->constrained('projects')->onDelete('set null');
            $table->json('notification_recipients');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('email_processing_rules');
    }
};
