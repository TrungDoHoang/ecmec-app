<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// PHP swagger doc
/**
 * @OA\Schema(
 *     schema="Introduction",
 *     type="object",
 *     required={"title_vn", "title_en", "address_en", "address_vn", "description_vn", "description_en", "salary", "is_show", "priority"},
 *     @OA\Property(property="title_vn", type="string"),
 *     @OA\Property(property="title_en", type="string"),
 *     @OA\Property(property="address_en", type="string"),
 *     @OA\Property(property="address_vn", type="string"),
 *     @OA\Property(property="description_vn", type="string"),
 *     @OA\Property(property="description_en", type="string"),
 *     @OA\Property(property="salary", type="number"),
 *     @OA\Property(property="is_show", type="boolean"),
 *     @OA\Property(property="priority", type="integer"),
 * )
 */
class Introduction extends Model
{
    use HasFactory;

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
