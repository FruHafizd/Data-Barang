<?php

namespace App\Models;

use App\Models\Stok;
use App\Models\Kategori;
use App\Models\DetailTransaksi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang', 'kode_barang', 'kategori_id', 'harga', 'stok', 'deskripsi', 'gambar'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function stok()
    {
        return $this->hasOne(Stok::class);
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }


}
