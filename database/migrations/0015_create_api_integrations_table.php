<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('api_integrations', function (Blueprint $table) {
            $table->id();
            $table->enum('name', ['gmail', 'whatsapp', 'google_cloud', 'deepl', 'google_translate', 'microsoft_translator']);
            $table->json('credentials');
            $table->enum('status', ['active', 'inactive', 'error'])->default('inactive');
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('api_integrations');
    }
};
