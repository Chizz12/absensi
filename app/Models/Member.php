<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';
    protected $primaryKey = 'id_member';
    protected $fillable = [
        'nama',
        'password',
        'id_member',
        'kota',
        'grup_id',
        'mkt',
        'hp1',
        'tag',
        'kode_komisi',
        'checkpoint',
        'email',
        'nik',
        'tg',
        'map',
        'total_kresya'
    ];


    public function user()
    {
        return $this->hasOne(User::class, 'member_id', 'id_member');
    }
    
    
}
