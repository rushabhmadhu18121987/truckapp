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
            $table->string('pickup_address')->nullable();
            $table->string('dropoff_address')->nullable();
            $table->string('pickup_date')->nullable();
            $table->string('dropoff_date')->nullable();
            $table->string('pickup_lat')->nullable();
            $table->string('pickup_lng')->nullable();
            $table->string('dropoff_lat')->nullable();
            $table->string('dropoff_lng')->nullable();
            $table->string('selected_mode')->nullable();
            $table->string('reservation_charge')->nullable();
            $table->string('depost_charge')->nullable();
            $table->string('service_charge')->nullable();
            $table->string('promo_code')->nullable();
            $table->string('promo_discount')->nullable();
            $table->string('insurance_charge')->nullable();
            $table->string('other_charge')->nullable();
            $table->string('message')->nullable();
            $table->string('confirmation')->nullable();
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
