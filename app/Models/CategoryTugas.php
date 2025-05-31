<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryTugas extends Model
{
    use HasFactory;

    protected $table = 'category_tugas';
    protected $primaryKey = 'id_category_tugas';
    protected $fillable = [
        'nama',
        'deskripsi',
    ];
}
