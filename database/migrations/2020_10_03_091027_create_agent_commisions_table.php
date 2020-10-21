<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentCommisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_commisions', function (Blueprint $table) {
            $table->id();
            $table->integer('agent_user_id');
            $table->integer('post_id');
            $table->string('commision_percent');
            $table->decimal('cost_of_post',6,2);
            $table->decimal('commision',6,2);
            $table->enum('agent_type',['agent','sub-agent']);
            $table->text('description')->nullable();
            $table->enum('status',['paid','pending'])->default('pending');
            $table->integer('payout_id')->default(0);
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
        Schema::dropIfExists('agent_commisions');
    }
}
