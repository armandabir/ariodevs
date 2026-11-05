<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->string('ip', 45)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->unsignedInteger('visits')->default(1);
            $table->timestamp('last_seen_at')->nullable();
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropColumn(['ip', 'country', 'city', 'visits', 'last_seen_at']);
        });
    }
};
