<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_metas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('object_id');
            $table->unsignedBigInteger('custom_field_type_id');
            $table->unsignedBigInteger('custom_field_id');
            $table->longText('value');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_metas');
    }
}
