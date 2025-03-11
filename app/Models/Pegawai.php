<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';

    protected $fillable = ['nama_pegawai', 'email', 'gajih', 'departemen_id', 'bonus_id'];

    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'departemen_id');
    }

    public function bonus()
    {
        return $this->belongsTo(Bonus::class, 'bonus_id');
    }

    public function getGajihBonusAttribute()
    {
        return $this->gajih + ($this->bonus ? $this->bonus->jumlah : 0);
    }
}
