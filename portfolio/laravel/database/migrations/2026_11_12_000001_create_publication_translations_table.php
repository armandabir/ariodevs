<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('publication_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('publication_id')->constrained()->cascadeOnDelete();
            $table->string('locale', 2);
            $table->string('title', 500);
            $table->string('venue', 255)->default('');
            $table->string('category', 255)->default('');
            $table->text('description')->nullable();
            $table->string('status', 20)->default('draft');
            $table->timestamps();

            $table->unique(['publication_id', 'locale']);
            $table->index(['locale', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('publication_translations');
    }
};
