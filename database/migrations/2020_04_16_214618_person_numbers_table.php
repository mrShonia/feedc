<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PersonNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_numbers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner_user_id');
            $table->integer('person_id');
            $table->string('number',30)->nullable(true);
            $table->index('owner_user_id');
            $table->index('person_id');
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
        //
        Schema::dropIfExists('person_numbers');
    }
}
