<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('contact_requests', function (Blueprint $table) {
            // Nullable at the DB level so existing rows stay valid; the form enforces it.
            $table->string('phone', 30)->nullable()->after('name');
        });

        // Raw statement avoids requiring doctrine/dbal for ->change().
        DB::statement('ALTER TABLE contact_requests MODIFY email VARCHAR(255) NULL');
    }

    public function down()
    {
        DB::table('contact_requests')->whereNull('email')->update(['email' => '']);
        DB::statement('ALTER TABLE contact_requests MODIFY email VARCHAR(255) NOT NULL');

        Schema::table('contact_requests', function (Blueprint $table) {
            $table->dropColumn('phone');
        });
    }
};
