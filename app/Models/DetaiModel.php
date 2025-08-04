<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetaiModel extends Model
{
    use HasFactory;
    protected $table = 'detai';
    protected $primaryKey = 'id_detai';
    protected $fillable = [
        'id_ttcn',
        'id_lvnc',
        'id_loaidt',
        'tendetai',
        'sothang',
        'hotenCN',
        'donvi',
        'sodt',
        'email',
        'tgbatdau',
        'tgketthuc',
        'sogiotg',
        'trangthai',
        'diemdanhgia',
        'nhanxet'
    ];
    public $timestamps = true;

    public function Thongtincanhan()
    {
        return $this->belongsTo(ThongtincanhanModel::class, 'id_ttcn');
    }
    public function Lichvucnghiencuu()
    {
        return $this->belongsTo(LinhvucnghiencuuModel::class, 'id_lvnc');
    }
    public function LoaiDT()
    {
        return $this->belongsTo(LoaidetaiModel::class, 'id_loaidt');
    }
    //------------------//
    public function KinhPhi()
    {
        return $this->hasMany(KinhphiModel::class, 'id_detai', 'id_detai');
    }
    public function TienDo()
    {
        return $this->hasMany(TiendoModel::class, 'id_detai', 'id_detai');
    }
    public function ThanhVien()
    {
        return $this->hasMany(ThanhvienModel::class, 'id_detai', 'id_detai');
    }
    public function TVhoidong()
    {
        return $this->hasMany(TVhoidongModel::class, 'id_detai', 'id_detai');
    }
    public function Sanpham()
    {
        return $this->hasMany(SanphamModel::class, 'id_detai', 'id_detai');
    }
}
