<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponPengaduan extends Model
{
    protected $table = 'respon_pengaduan';
    protected $fillable = ['pengaduan_id', 'user_id', 'isi_respon'];

    public function pengaduan() {
        return $this->belongsTo(Pengaduan::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}