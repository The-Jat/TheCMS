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
        Schema::create('configurations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 64);
            $table->text('value')->nullable();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('input_type')->nullable();
            $table->tinyInteger('editable')->default(1);
            $table->integer('weight')->nullable();
            $table->text('params')->nullable();
            $table->integer('order')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configurations');
    }
};
