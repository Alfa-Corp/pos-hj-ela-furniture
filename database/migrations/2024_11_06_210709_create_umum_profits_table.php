<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('umum_profits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('umum_transaction_id');
            $table->bigInteger('total');
            $table->timestamps();

            //relationship transactions
            $table->foreign('umum_transaction_id')->references('id')->on('umum_transactions');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('umum_profits');
    }
};
