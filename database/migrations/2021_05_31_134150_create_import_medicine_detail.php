<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportMedicineDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_medicine_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('import_id')->index();
            $table->tinyInteger('medicine_code')->index();
            $table->tinyInteger('amount');
            $table->bigInteger('cost_per_med');
            $table->bigInteger('total_amount');
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
        Schema::dropIfExists('import_medicine_detail');
    }
}
