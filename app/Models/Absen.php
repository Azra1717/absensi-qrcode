<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;
    protected $fillable = ['siswa_id', 'tanggal'];

    public function siswa()
    {
        return $this->belongsTo(User::class,  'siswa_id');
    }
}
