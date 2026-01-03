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
        Schema::create('page_seos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('page_id')->index('page_seos_page_id_foreign');
            $table->string('page_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('meta_descriptions')->nullable();
            $table->string('content_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_seos');
    }
};
