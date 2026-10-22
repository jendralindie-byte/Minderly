<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $table = 'tugas';
    protected $primaryKey = 'id_tugas';
    public $timestamps = false;

    protected $fillable = [
        'id_pengguna',
        'id_kategori',
        'penanggung_jawab',
        'judul',
        'deskripsi',
        'deadline',
        'tingkat_kesulitan',
        'dampak',
        'skor_prioritas',
        'status'
    ];

    public function kategori()
    {
        return $this->belongsTo(
            Kategori::class,
            'id_kategori',
            'id_kategori'
        );
    }
}