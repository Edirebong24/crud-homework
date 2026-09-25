<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class motor extends Model
{
    use HasFactory;
    protected $table = 'motor' ;
    protected $fillable = [
        'gambar',
        'nama',
        'deskripsi',
        'harga',
        'stok',
    ];
}
