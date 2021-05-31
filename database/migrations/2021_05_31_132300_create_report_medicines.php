<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportMedicines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_medicines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('day');
            $table->tinyInteger('month');
            $table->tinyInteger('year');
            $table->tinyInteger('medicine_code')->index();
            $table->tinyInteger('amount');
            $table->tinyInteger('times');
            $table->tinyInteger('user_id');
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
        Schema::dropIfExists('report_medicines');
    }
}
