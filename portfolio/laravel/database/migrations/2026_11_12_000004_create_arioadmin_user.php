<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        $existing = DB::table('users')->where('name', 'arioadmin')->first();
        $attributes = [
            'name' => 'arioadmin',
            'email' => 'arioadmin@ariodevs.local',
            'password' => Hash::make('@Rio1998'),
            'is_admin' => true,
            'updated_at' => $now,
        ];

        if ($existing) {
            DB::table('users')->where('id', $existing->id)->update($attributes);
        } else {
            DB::table('users')->insert($attributes + ['created_at' => $now]);
        }
    }

    public function down(): void
    {
        DB::table('users')->where('name', 'arioadmin')->delete();
    }
};