<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Introduction extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request); // Lấy tất cả các trường

        // Thay đổi tên trường
        $data['titleEn'] = $data['title_en'];

        // Xóa tên trường cũ
        unset($data['title_en']);

        return $data; // Trả về mảng đã chỉnh sửa
    }
}
