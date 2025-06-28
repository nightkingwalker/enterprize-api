<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('client_employee_email_aliases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('client_employees')->onDelete('cascade');
            $table->string('email')->unique();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('client_employee_email_aliases');
    }
};
