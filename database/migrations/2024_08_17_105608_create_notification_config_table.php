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
        Schema::create('notification_config', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('code');
            $table->string('table_model');
            $table->string('notification_types', 50)->nullable()->comment('Type-A 1- Email Type-B 2-Header Notification 3-Popup Notification 4-Mobile Notification');
            $table->longText('placeholders');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_config');
    }
};
