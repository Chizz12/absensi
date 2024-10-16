<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;

    protected $table = 'absens';

    protected $primaryKey = 'id_absen';

    protected $fillable = [
        'user_id',
        'shift_id',
        'type',
        'foto',
        'latitude',
        'longitude',
        'status'
    ];

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id', 'id_shift');
    }
}
