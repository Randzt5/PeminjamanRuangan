<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    // Izinkan kolom-kolom ini untuk diisi secara massal
    protected $fillable = [
        'peminjaman_id',
        'file_form',
        'catatan',
    ];
}