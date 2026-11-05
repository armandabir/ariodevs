<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->string('timezone', 64)->nullable();
            $table->string('ip_timezone', 64)->nullable();
            $table->boolean('vpn_suspected')->default(false);
        });
    }

    public function down()
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->dropColumn(['timezone', 'ip_timezone', 'vpn_suspected']);
        });
    }
};
