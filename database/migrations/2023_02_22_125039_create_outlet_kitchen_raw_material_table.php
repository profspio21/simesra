<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outlet_kitchen_raw_material', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ok_id')->references('id')->on('outlet_kitchens');
            $table->foreignId('rm_id')->references('id')->on('raw_materials');
            $table->integer('qty')->nullable();
            $table->unique(array('ok_id', 'rm_id'));
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
        Schema::dropIfExists('outlet_kitchen_raw_material_pivot');
    }
};
