<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtractResultFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extract_result_features', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('extract_result_id');
            $table->foreign('extract_result_id')->references('id')->on('extract_results');
            $table->mediumText('feature')->nullable();
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
        Schema::dropIfExists('extract_result_features');
    }
}
