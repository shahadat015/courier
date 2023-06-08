<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrowRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrow_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('bank_account_id')
                ->constrained('bank_accounts')
                ->onDelete('cascade');
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
        Schema::dropIfExists('withdrow_requests');
    }
}
