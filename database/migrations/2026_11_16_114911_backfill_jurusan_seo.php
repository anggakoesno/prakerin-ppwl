<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \App\Models\Jurusan::whereNull('jurusan_seo')->get()->each(function ($j) {
            $slug = \Illuminate\Support\Str::slug($j->nama);
            if (\App\Models\Jurusan::where('jurusan_seo', $slug)->where('id', '!=', $j->id)->exists()) {
                $slug .= '-' . $j->id;
            }
            $j->jurusan_seo = $slug;
            $j->save();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
