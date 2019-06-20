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
            $table->integer('expense_item_type')->comment('expense_item_type   1=Kacabazar/suknabazar 2= Others');
            $table->integer('expense_amount');
            $table->integer('due_pay_type')->nullable()->comment('1=due Mill pabe    2 = pay  mill dibe');
            $table->integer('due_pay_amount')->nullable();
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
