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
        Schema::create('term_relationships', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('object_id');
            $table->bigInteger('term_id');
            $table->tinyInteger('object_type')->default(1)->comment('1 => Blog, 2 => Page');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('term_relationships');
    }
};
