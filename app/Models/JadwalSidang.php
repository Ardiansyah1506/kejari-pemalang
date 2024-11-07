<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalSidang extends Model
{
    use HasFactory;

    protected $table = 'jadwal_sidang';
    protected $guarded = ['id'];
}
