<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('temp_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('parent_id');
            $table->string('name');
            $table->string('path');
            $table->string('controller')->nullable();
            $table->string('action')->nullable();
            $table->enum('type', ['App', 'Module', 'Controller', 'Action'])->default('App');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_permissions');
    }
};
