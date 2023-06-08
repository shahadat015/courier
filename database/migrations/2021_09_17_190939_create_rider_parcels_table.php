<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiderParcelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rider_parcels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rider_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->float('collection_amount');
            $table->integer('total_parcel');
            $table->float('delivered_amount')->default(0);
            $table->float('returned_amount')->default(0);
            $table->float('half_returned_amount')->default(0);
            $table->float('pending_amount')->default(0);
            $table->integer('total_delivered')->default(0);
            $table->integer('total_returned')->default(0);
            $table->integer('total_half_returned')->default(0);
            $table->integer('total_pending')->default(0);
            $table->string('status')->default('Pending');
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
        Schema::dropIfExists('rider_parcels');
    }
}
