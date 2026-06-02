<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanphamModel extends Model
{
    use HasFactory;
    protected $table = 'sanpham';
    protected $primaryKey = 'id_sanpham';
    protected $fillable = [
        'id_loai',
        'id_detai',
        'linkSP',
        'tenSP',
        'trangthai',
    ];
    public $timestamps = true;
    public function Loaisanpham()
    {
        return $this->belongsTo(LoaispnghiencuuModel::class, 'id_loai');
    }

    public function Detai()
    {
        return $this->belongsTo(DetaiModel::class, 'id_detai');
    }
}
