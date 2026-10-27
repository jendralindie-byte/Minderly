<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilPengguna extends Model
{
    protected $table = 'profil_pengguna';

    protected $primaryKey = 'id_profil';

    protected $fillable = [
        'id_pengguna',
        'riset',
        'menulis',
        'desain',
        'presentasi',
        'analisis',
        'perencanaan',
        'ketelitian',
        'kolaborasi',
        'disiplin_deadline',
        'mandiri',
        'waktu_tersedia',
        'beban_kerja',
    ];

    public function pengguna()
    {
        return $this->belongsTo(
            Pengguna::class,
            'id_pengguna',
            'id_pengguna'
        );
    }
}
