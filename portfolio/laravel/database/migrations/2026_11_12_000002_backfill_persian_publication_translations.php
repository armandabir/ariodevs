<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::table('publications')->orderBy('id')->each(function ($publication) {
            DB::table('publication_translations')->updateOrInsert(
                ['publication_id' => $publication->id, 'locale' => 'fa'],
                [
                    'title' => $publication->title,
                    'venue' => $publication->venue,
                    'category' => $publication->category,
                    'description' => $publication->description,
                    'status' => 'approved',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        });
    }

    public function down()
    {
        DB::table('publication_translations')->where('locale', 'fa')->delete();
    }
};
