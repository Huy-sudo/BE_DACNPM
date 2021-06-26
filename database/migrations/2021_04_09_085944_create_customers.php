<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->index();
            $table->string('name');
            $table->tinyinteger('sex')->comment('1-male; 0-undefined; 2-female')->nullable();
            $table->string('phone')->unique();
            $table->year('birth')->nullable();
            $table->string('address')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1-active; 2-deleted');

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
        Schema::dropIfExists('customers');
    }
}
