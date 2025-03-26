<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['title_vn', 'title_en', 'description_vn', 'description_en', 'is_show', 'priority', 'created_by', 'updated_by'];

    // Quan hệ với các bảng khác
    public function userCreated()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function userUpdated()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_service', 'service_id', 'project_id');
    }

    public function isDeleted(): bool
    {
        return ! is_null($this->deleted_at);
    }
}
