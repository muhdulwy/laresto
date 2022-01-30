<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'menu_id',
        'jumlah',
        'tgl_order',
    ];

    public function menu(){
        return $this->belongsTo(Menu::class);
    }
}