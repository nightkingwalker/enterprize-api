<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('glossary_terms', function (Blueprint $table) {
            $table->id();
            $table->string('term');
            $table->string('translation');
            $table->string('source_language', 10);
            $table->string('target_language', 10);
            $table->foreignId('project_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('client_id')->nullable()->constrained()->onDelete('set null');
            $table->text('definition')->nullable();
            $table->text('context')->nullable();
            $table->timestamps();

            $table->index(['term', 'source_language']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('glossary_terms');
    }
};
