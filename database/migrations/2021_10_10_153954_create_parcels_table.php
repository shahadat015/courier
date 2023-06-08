<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParcelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->unsignedBigInteger('rider_id')
                ->nullable();
            $table->unsignedBigInteger('rider_parcel_id')
                ->nullable();
            $table->unsignedBigInteger('payment_id')
                ->nullable();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_address');
            $table->string('invoice_no')->nullable();
            $table->float('collection_amount')->nullable();
            $table->float('charge')->nullable();
            $table->text('parcel_note')->nullable();
            $table->string('status')->default('On Review');
            $table->timestamps();

            $table->foreign('rider_id')->references('id')->on('users');
            $table->foreign('payment_id')->references('id')->on('payments');
            $table->foreign('rider_parcel_id')->references('id')->on('rider_parcels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parcels');
    }
}
