<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMillHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mill_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->comment("Primay key from user table");
            $table->date('date');
            $table->tinyInteger('mill_status')->default(0);
            $table->tinyInteger('mill_status2')->default(0);
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
        Schema::dropIfExists('mill_histories');
    }
}
