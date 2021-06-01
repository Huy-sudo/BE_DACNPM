<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicinesInventory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicines_inventory', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('medicine_id')->index();
            $table->tinyInteger('amount')->index();
            $table->tinyInteger('type')->default(1)->comment('1-import; 2-export')->nullable(); 
            $table->bigInteger('cost_per_med')->index();
            $table->bigInteger('total');
            $table->tinyInteger('in_stock_after')->index();
            $table->tinyInteger('status')->default(1)->comment('1-active; 0-deleted; 2-inactive');

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
        Schema::dropIfExists('medicines_inventory');
    }
}
