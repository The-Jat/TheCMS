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
        Schema::create('languages', function (Blueprint $table) {
            $table->increments('id');
            $table->char('title', 49)->nullable();
            $table->char('language_code', 2)->nullable();
            $table->integer('country_id')->nullable();
            $table->string('country', 500)->nullable();
            $table->string('country_code', 500)->nullable();
            $table->enum('is_universal', ['0', '1'])->nullable()->default('0');
            $table->enum('is_main', ['0', '1'])->nullable()->default('0');
            $table->enum('is_regional', ['0', '1'])->nullable()->default('0');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
