<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMillAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mill_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->comment('Primary Key from User Id');
            $table->integer('expense_type')->comment('expense type   1=bazar 2= joma   (use query for report joma and bazar)');
            $table->integer('expense_item_type')->comment('expense_item_type   1=Kacabazar/suknabazar 2= Others')->nullable();
            $table->integer('expense_amount');
            $table->string('note')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('mill_accounts');
    }
}
