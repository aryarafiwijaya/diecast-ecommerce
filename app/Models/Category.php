<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    // Tambahkan kolom yang bisa diisi (misalnya hanya 'name' untuk sekarang)
    protected $fillable = ['name'];

    // Relasi ke Product
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}