<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permit extends Model
{
    use HasFactory;

    protected $table = 'permits';

    protected $primaryKey = 'id_permit';

    protected $fillable = [
        'user_id',
        'category',
        'level',
        'start_date',
        'end_date',
        'time',
        'reason',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    public function kadiv()
    {
        return $this->belongsTo(User::class, 'approved_by_kadiv', 'id_user');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'approved_by_manager', 'id_user');
    }
}
