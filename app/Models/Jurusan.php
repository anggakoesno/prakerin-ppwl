<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jurusan extends Model
{
    protected $table = 'jurusan';

    protected $fillable = ['nama', 'kode'];

    public function kompetensi(): HasMany
    {
        return $this->hasMany(Kompetensi::class, 'jurusan_id');
    }
}
