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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('parent_id')->nullable()->default(0);
            $table->unsignedBigInteger('menu_id')->index('menu_items_menu_id_foreign');
            $table->bigInteger('item_id')->nullable()->default(0);
            $table->string('type')->comment('Page, Link, Category, Post, Tag, Cpt');
            $table->string('title');
            $table->string('attribute')->nullable();
            $table->string('link')->nullable();
            $table->tinyInteger('menu_target')->nullable()->default(0);
            $table->text('css_classes')->nullable();
            $table->longText('description')->nullable();
            $table->bigInteger('order')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
