<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'menu';
    protected $fillable = [
        'nama',
        'deskripsi',
        'kategori',
        'harga',
        'foto'
    ];

    public function orders(){
        return $this->hasMany(Orders::class);
    }
}