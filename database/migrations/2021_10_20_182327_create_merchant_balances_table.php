<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->float('debit')->default(0);
            $table->float('credit')->default(0);
            $table->string('note')->default('parcel_delivery');
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
        Schema::dropIfExists('merchant_balances');
    }
}
