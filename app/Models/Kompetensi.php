<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kompetensi extends Model
{
    protected $table = 'kompetensi';

    protected $fillable = ['jurusan_id', 'nama', 'kode'];

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }
}
