<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'emailVerified' => boolval($this->email_verified_at),
            'phone' => $this->phone,
            'isDelete' => $this->isDeleted(),
            'createdAt' => $this->created_at->toIso8601String(),
            'updatedAt' => $this->updated_at->toIso8601String(),
            'img' => new ImageResource($this->image),
            'roles' => $this->roles->map(function ($role) {
                return [
                    'id' => $role->id,
                    'roleName' => $role->role_name,
                    'createdAt' => $role->created_at->toIso8601String(),
                    'updatedAt' => $role->updated_at->toIso8601String(),
                ];
            }),
        ];
    }
}
