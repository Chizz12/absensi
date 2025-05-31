<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimerTugas extends Model
{
    use HasFactory;

    protected $table = 'timer_tugas';
    protected $primaryKey = 'id_timer_tugas';
    protected $fillable = [
        'tugas_id',
        'tipe',
        'status'
    ];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'tugas_id', 'id');
    }
}
