<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Introductions extends Model
{
    use HasFactory;

    // Nếu tên bảng khác với quy ước (plural hóa tên model)
    // protected $table = 'products';

    protected $fillable = ['title_vn', 'title_en', 'address_en', 'address_vn', 'description_vn', 'description_en', 'salary', 'is_show', 'priority', 'is_delete', 'created_by', 'updated_by'];

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
