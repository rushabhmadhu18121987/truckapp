<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Orders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('vehicle_id')->nullable();
            $table->string('pickup')->nullable();
            $table->string('drop_off')->nullable();
            $table->string('pickup_lat')->nullable();
            $table->string('pickup_lng')->nullable();
            $table->string('dropoff_lat')->nullable();
            $table->string('dropoff_lng')->nullable();
            $table->string('selected_mode')->nullable();
            $table->string('daily_price')->nullable();
            $table->string('weekly_price')->nullable();
            $table->string('mothly_price')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('orders');
        //
    }
}
