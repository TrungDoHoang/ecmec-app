<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Introductions extends Model
{
    use HasFactory;

    // Nếu tên bảng khác với quy ước (plural hóa tên model)
    // protected $table = 'products';

    protected $fillable = ['title_vn', 'title_en', 'address_en', 'address_vn', 'description_vn', 'description_en', 'salary', 'is_show', 'priority', 'isDelete', 'created_by'];

    // Quan hệ với các bảng khác
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
