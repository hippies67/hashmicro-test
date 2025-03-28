<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    use HasFactory;

    protected $table = 'bonuses';

    protected $fillable = ['nama_bonus', 'jumlah'];

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'id');
    }
}
