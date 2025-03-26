<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeContent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title_vn', 'title_en', 'description_vn', 'description_en', 'img_id', 'is_show', 'priority', 'created_by', 'updated_by'];

    // Quan hệ với các bảng khác
    public function userCreated()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function userUpdated()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'img_id');
    }

    public function isDeleted()
    {
        return !is_null($this->deleted_at);
    }
}
