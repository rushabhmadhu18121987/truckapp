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
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('phone')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->integer('payment_mode')->nullable();
            $table->tinyInteger('status');
            $table->integer('user_type_id')->nullable();
            $table->integer('user_role_id')->nullable();
            $table->integer('otp')->nullable();
            $table->tinyInteger('is_verify');
            $table->tinyInteger('is_blocked');
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
