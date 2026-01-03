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
        Schema::create('custom_fields', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent_id')->default(0);
            $table->string('key');
            $table->string('title');
            $table->string('value')->nullable();
            $table->longText('placeholder')->nullable();
            $table->longText('description')->nullable();
            $table->tinyInteger('editable')->default(1);
            $table->string('input_type');
            $table->longText('params')->nullable();
            $table->enum('required', ['0', '1'])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_fields');
    }
};
