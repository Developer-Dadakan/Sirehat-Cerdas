<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiObatDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_transaksi_obat',
        'id_obat',
        'ket'
    ];

    public function TransaksiObat()
    {
        return $this->belongsTo(TransaksiObat::class, 'id_transaksi_obat');
    }

    public function Obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }

    public function AntarObat()
    {
        return $this->hasMany(AntarObat::class);
    }

    
}
