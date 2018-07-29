<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email');
            $table->string('password')->nullable();
            $table->string('mobile')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('referral_code')->nullable();
            $table->string('is_subscribers')->nullable();
            $table->string('user_login_type')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->integer('payment_mode')->nullable();
            $table->integer('otp')->nullable();
            $table->integer('status')->default(0);
            $table->tinyInteger('is_verify')->default(0);
            $table->double('user_lat',20,8)->nullable();
            $table->double('user_long',20,8)->nullable();
            $table->string('driving_licence_doc')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
