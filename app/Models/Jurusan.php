<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Jurusan extends Model
{
    protected $table = 'jurusan';

    protected $fillable = ['nama', 'kode', 'filename', 'filepath', 'jurusan_seo', 'foto'];

    public function kompetensi(): HasMany
    {
        return $this->hasMany(Kompetensi::class, 'jurusan_id');
    }

    public function photos()
    {
        return $this->hasMany(Kompetensi::class, 'jurusan_id', 'id');
    }
}
