<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gender');
            $table->string('email');
            $table->string('phone');
            $table->string('voucher_code');
            $table->decimal('commission',5,2);
            $table->string('commission_validity');
            $table->string('payment_method');
            $table->string('payout_email');
            $table->string('country');
            $table->string('phone_verified');
            $table->string('active');
            $table->string('parent_id');
            $table->string('own_user_id');
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
        Schema::dropIfExists('agents');
    }
}
