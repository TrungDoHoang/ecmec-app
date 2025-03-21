<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruimentPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_vn',
        'title_en',
        'content_vn',
        'content_en',
        'address_vn',
        'address_en',
        'salary',
        'is_show',
        'priority',
        'is_delete',
        'created_by',
        'updated_by',
    ];

    // Quan hệ với các bảng khác
    public function userCreated()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function userUpdated()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
