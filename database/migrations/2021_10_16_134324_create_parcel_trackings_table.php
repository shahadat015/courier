<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParcelTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcel_trackings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parcel_id')
                ->constrained('parcels')
                ->onDelete('cascade');
                $table->string('status');
                $table->text('description')->nullable();
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
        Schema::dropIfExists('parcel_trackings');
    }
}
