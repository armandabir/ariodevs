<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->integer('page_id');
            $table->integer('sect_id');
            $table->string('sect_name',255);
            $table->string('title',255)->nullable();
            $table->string("pic",255)->nullable();
            $table->text("desc",1000)->nullable();
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
        Schema::dropIfExists('pages');
    }
};
