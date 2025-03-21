<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        // Lấy tất cả lỗi dưới dạng mảng
        $errors = $validator->errors()->toArray();

        // Chỉ lấy phần tử đầu tiên của mỗi trường lỗi
        $formattedErrors = [];
        foreach ($errors as $field => $errorMessages) {
            $formattedErrors[$field] = $errorMessages[0]; // Lấy thông báo lỗi đầu tiên
        }
        throw new HttpResponseException(response()->json([
            'message' => 'Validation failed', // Customize message tổng hợp
            'errors' => $formattedErrors,
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
