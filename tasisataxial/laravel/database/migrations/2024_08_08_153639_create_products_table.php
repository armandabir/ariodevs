<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("name",255);
            $table->string("slug",255);
            $table->string("pic",255);
            $table->integer("price");
            $table->string("content",1000);
            $table->boolean("publish")->default(0);
            $table->unsignedBigInteger("cat_id");
            $table->timestamps();
            $table->foreign("cat_id")->references("id")->on("categories")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
