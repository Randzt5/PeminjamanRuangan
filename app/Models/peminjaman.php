<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Form;
use App\Models\User;
use App\Models\Ruangan; // <-- TAMBAHKAN INI

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    protected $fillable = [
        'user_id',
        'ruangan_id', // Pastikan ini sudah ada dari refactoring kita sebelumnya
        'nama_kegiatan',
        'jenis_kegiatan',
        'tanggal_peminjaman',
        'waktu_mulai',
        'waktu_selesai',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function form()
    {
        return $this->hasOne(Form::class);
    }

    /**
     * TAMBAHKAN FUNGSI RELASI BARU INI
     * Mendefinisikan bahwa setiap Peminjaman merujuk ke satu Ruangan.
     */
    public function ruangan()
    {
        // Relasinya adalah 'belongsTo' (dimiliki oleh) Ruangan
        // Kunci asingnya adalah 'ruangan_id'
        return $this->belongsTo(Ruangan::class);
    }
}