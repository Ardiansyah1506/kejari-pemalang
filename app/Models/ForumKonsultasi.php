<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumKonsultasi extends Model
{
    use HasFactory;

    protected $table = 'forum_konsultasi';
    protected $fillable = ['nama','alamat','email','no_hp','keterangan','dokumen_pendukung'];

}
