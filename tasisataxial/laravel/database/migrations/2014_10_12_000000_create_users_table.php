<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string("firstName",255);
            $table->string('lastName',255);
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string("username",255);
            $table->string("phone_number",255)->nullable();
            $table->string('password');
            $table->boolean("gender")->nullable();
            $table->integer("role_as");
            $table->text("address",1000)->nullable();
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
