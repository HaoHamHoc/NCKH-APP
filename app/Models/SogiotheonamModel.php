<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SogiotheonamModel extends Model
{
    use HasFactory;
    protected $table = 'sogiotheonam';
    protected $primaryKey = 'id_nam';
    protected $fillable = [
        'id_loaidt',
        'sogioTGtoida',
        'sogioTVtoida',
        'soTVtoida',
        'nam',
    ];
    public $timestamps = true;
    public function Loaidetai()
    {
        return $this->belongsTo(LoaidetaiModel::class, 'id_loaidt');
    }
}
