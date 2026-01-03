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
        Schema::create('blogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable()->default(0);
            $table->string('title');
            $table->string('slug');
            $table->text('content')->nullable();
            $table->text('excerpt')->nullable();
            $table->tinyInteger('comment')->nullable();
            $table->string('password')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1 => Published, 2 => Draft, 3 => Trash, 4 => Private, 5 => Pending');
            $table->string('post_type')->default('blog');
            $table->enum('visibility', ['Pu', 'PP', 'Pr'])->comment('Pu => Public, PP => Password Protected, Pr => Private');
            $table->dateTime('publish_on')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
