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
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('parent_id')->nullable()->default(0);
            $table->unsignedBigInteger('user_id');
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->enum('page_type', ['Page', 'Widget'])->nullable();
            $table->text('content')->nullable();
            $table->text('excerpt')->nullable();
            $table->tinyInteger('comment')->nullable();
            $table->string('password')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1 => Published, 2 => Draft, 3 => Trash, 4 => Private, 5 => Pending');
            $table->enum('visibility', ['Pu', 'PP', 'Pr'])->comment('Pu => Public, PP => Password Protected, Pr => Private');
            $table->dateTime('publish_on')->nullable();
            $table->bigInteger('order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
