<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    // Jangan gunakan SoftDeletes
    // use SoftDeletes;

    protected $table = 'pengaduan';  

    protected $fillable = [
        'user_id',
        'kategori_id',
        'judul',
        'isi',
        'status',
        'is_deleted', // Kolom is_deleted digunakan untuk soft deletee
    ];

    // Scope untuk mengambil data yang belum dihapus
    public function scopeActive($query)
    {
        return $query->where('is_deleted', false);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriPengaduan::class, 'kategori_id');
    }

    public function respon()
{
    return $this->hasMany(ResponPengaduan::class, 'pengaduan_id');
}

}
