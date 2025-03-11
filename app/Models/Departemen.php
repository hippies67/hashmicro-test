<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;

    protected $table = 'departemens';

    protected $fillable = ['nama_departemen', 'deskripsi'];

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'id');
    }
}
