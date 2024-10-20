<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanKonsultasi extends Model
{
    use HasFactory;

    protected $table = 'jawaban_konsultasi';
    protected $fillable = ['id_forum','keterangan',];
}
