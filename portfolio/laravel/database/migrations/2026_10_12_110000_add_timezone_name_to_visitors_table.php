<?php

use App\Models\Visitor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->string('timezone_name', 100)->nullable()->after('timezone');
        });

        Visitor::whereNotNull('timezone')->get()->each(function (Visitor $v) {
            $v->timezone_name = Visitor::readableTimezone($v->timezone);
            $v->save();
        });
    }

    public function down()
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->dropColumn('timezone_name');
        });
    }
};
