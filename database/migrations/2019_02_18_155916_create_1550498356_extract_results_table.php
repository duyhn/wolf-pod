<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create1550498356ExtractResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('extract_results')) {
            Schema::create('extract_results', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('link_id');
                $table->foreign('link_id')->references('id')->on('links');
                $table->mediumText('title')->nullable();
                $table->mediumText("branch")->nullable();
                $table->mediumText('description')->nullable();
                $table->string('price')->nullable();
                $table->mediumText("image_mockup")->nullable();
                $table->string('image_original')->nullable();
                $table->string('image_clean')->nullable();
                $table->string("asin")->nullable();
                $table->string("public_date")->nullable();
                $table->mediumText("rank")->nullable();
                $table->timestamps();
                $table->softDeletes();
                $table->index(['deleted_at']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extract_results');
    }
}
