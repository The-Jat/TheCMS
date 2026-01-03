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
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('notification_config_id');
            $table->string('notification_types', 50);
            $table->bigInteger('object_id');
            $table->bigInteger('sender_id')->nullable();
            $table->bigInteger('receiver_id')->nullable();
            $table->enum('read', ['0', '1'])->default('0')->comment('0=Unread, 1=read');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
