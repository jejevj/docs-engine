<?php

namespace App\Models\Manajemen;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MPosts extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 't_posts';

    protected $fillable = [
        'judul_posts',
        'deskripsi',
        'id_modul',
        'parent_post_id',
        'filename',
        'file_location',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relationships
    public function modul()
    {
        return $this->belongsTo(MModul::class, 'id_modul');
    }

    public function parentPost()
    {
        return $this->belongsTo(MPosts::class, 'parent_post_id');
    }

    public function childPosts()
    {
        return $this->hasMany(MPosts::class, 'parent_post_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}