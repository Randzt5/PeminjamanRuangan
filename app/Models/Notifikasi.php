<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    /**
     * BERI TAHU LARAVEL NAMA TABEL YANG SEBENARNYA.
     *
     * @var string
     */
    protected $table = 'notifikasi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'pesan', 'status_baca','peminjaman_id'];
}
