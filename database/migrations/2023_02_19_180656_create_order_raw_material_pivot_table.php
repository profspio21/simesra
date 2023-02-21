<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderRawMaterialPivotTable extends Migration
{
    public function up()
    {
        Schema::create('order_raw_material', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id', 'order_id_fk_8054275')->references('id')->on('orders')->onDelete('cascade');
            $table->unsignedBigInteger('raw_material_id');
            $table->foreign('raw_material_id', 'raw_material_id_fk_8054275')->references('id')->on('raw_materials')->onDelete('cascade');
            $table->integer('quantity');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }
}