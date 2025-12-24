<?php

namespace App\Models;

use App\Models\Manajemen\MKategori;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MModul extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'm_modul';

    protected $fillable = [
        'nama_modul',
        'id_kategori',
        'nama_kategori',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relationships
    public function kategori()
    {
        return $this->belongsTo(MKategori::class, 'id_kategori');
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