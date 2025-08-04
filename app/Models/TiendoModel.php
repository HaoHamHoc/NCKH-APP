<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiendoModel extends Model
{
    use HasFactory;
    protected $table = 'tiendo';
    protected $primaryKey = 'id_tiendo';
    protected $fillable = [
        'id_detai',
        'ndcongviec',
        'tgbatdau',
        'tgketthuc',
        'trangthai',
        'nguoithuchien',
        'thang'
    ];
    public $timestamps = true;
    public function Detai()
    {
        return $this->belongsTo(DetaiModel::class, 'id_detai');
    }
    public function Kinhphi()
    {
        return $this->hasMany(KinhphiModel::class, 'id_tiendo', 'id_tiendo');
    }
}
