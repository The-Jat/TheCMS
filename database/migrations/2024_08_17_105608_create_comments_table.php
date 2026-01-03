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
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('parent_id')->nullable()->default(0);
            $table->unsignedBigInteger('object_id')->nullable()->default(0);
            $table->unsignedBigInteger('user_id')->nullable()->default(0);
            $table->enum('object_type', ['1', '2'])->comment('1 => \'Blog\', 2 => \'Page\'');
            $table->string('commenter')->nullable();
            $table->string('profile_url')->nullable();
            $table->string('ip');
            $table->string('email')->nullable();
            $table->text('comment')->nullable();
            $table->enum('approve', ['0', '1', '2', '3'])->comment('0 => moderation / pending, 1 => approved, 2 => spam, 3 => trash');
            $table->string('browser_agent');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
