<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSomeFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_elements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('form_id')->nullable();
            $table->string('element_name',45)->nullable();
            $table->string('element_title',45)->nullable();
            $table->string('element_value',45)->nullable();
            $table->tinyInteger('element_type')->nullable();
            $table->timestamps();
        });
        Schema::create('forms', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('user_id')->nullable();
            $table->string('form_title',45)->nullable();
            $table->timestamps();
        });
        Schema::create('radios', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('element_id')->nullable();
            $table->string('radio_value',45)->nullable();
            $table->string('radio_text',45)->nullable();
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
        Schema::dropIfExists('form_elements');
        Schema::dropIfExists('form');
        Schema::dropIfExists('radios');
    }
}
