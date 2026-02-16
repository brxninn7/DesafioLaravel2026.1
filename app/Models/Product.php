<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory; 

    protected $fillable = [
        'titulo',
        'descricao',
        'preco',
        'estoque',
        'marca',
        'tipo',
        'categoria',
        'user_id' 
    ];

    public function images(){
        return $this->hasMany(ProductImage::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}