<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_vn',
        'title_en',
        'description_vn',
        'description_en',
        'address_vn',
        'address_en',
        'investor_vn',
        'investor_en',
        'main_contractor_vn',
        'main_contractor_en',
        'status',
        'area',
        'duration',
        'start_date',
        'priority',
        'is_show',
        'is_delete',
        'created_by',
        'updated_by',
        'project_type_id',
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

    public function projectType()
    {
        return $this->belongsTo(ProjectType::class, 'project_type_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class, 'project_id');
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'project_service', 'project_id', 'service_id');
    }
}
