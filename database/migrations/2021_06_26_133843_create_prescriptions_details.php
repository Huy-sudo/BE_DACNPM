<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionsDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriptions_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->index();
            $table->string('prescription_id')->index();
            $table->bigInteger('price_medicines')->nullable();
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
        Schema::dropIfExists('prescriptions_details');
    }
}