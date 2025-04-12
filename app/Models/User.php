<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password', 'role'];
    public $timestamps = true;

    public function pengaduan() {
        return $this->hasMany(Pengaduan::class);
    }

    public function respon() {
        return $this->hasMany(ResponPengaduan::class);
    }
}