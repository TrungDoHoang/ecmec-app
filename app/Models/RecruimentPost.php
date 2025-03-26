<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecruimentPost extends Model
{
    use HasFactory, SoftDeletes;

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

    public function isDeleted()
    {
        return !is_null($this->deleted_at);
    }
}
