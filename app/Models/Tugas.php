<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'category_tugas_id',
        'project_id',
        'divisi_id',
        'user_id',
        'nama',
        'start_date',
        'deadline',
        'end_date',
        'prioritas',
        'approved_by',
        'approved_at',
        'persentase',
        'status',
        'berita',
        'keterangan',
        'link'
    ];

    public function categoryTugas()
    {
        return $this->belongsTo(CategoryTugas::class, 'category_tugas_id', 'id_category_tugas');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id_project');
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'divisi_id', 'id_divisi');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id_user');
    }

    public static function countPendingTugas()
    {
        return self::where('status', 'belum_dikerjakan')
            ->where('user_id', auth()->id())
            ->count();
    }

    public static function countAccTugas()
    {
        return self::where('status', 'pending')
            ->count();
    }
}
