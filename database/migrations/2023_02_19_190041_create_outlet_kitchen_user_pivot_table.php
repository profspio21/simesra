<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutletKitchenUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('outlet_kitchen_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('outlet_kitchen_id');
            $table->foreign('outlet_kitchen_id', 'outlet_kitchen_id_fk_8054141')->references('id')->on('outlet_kitchens')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_8054141')->references('id')->on('users')->onDelete('cascade');
        });
    }
}