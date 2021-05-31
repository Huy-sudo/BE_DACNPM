<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportRevenuesDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_revenues_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('report_id')->index();
            $table->tinyInteger('day');
            $table->bigInteger('revenue');
            $table->tinyInteger('customers');
            $table->double('ratio',8,2);
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
        Schema::dropIfExists('report_revenues_detail');
    }
}
