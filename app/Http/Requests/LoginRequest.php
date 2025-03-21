<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

/**
 * @OA\Schema(
 *     schema="LoginRequest",
 *     type="object",
 *     required={"email", "password"},
 *     @OA\Property(property="email", type="string", format="email"),
 *     @OA\Property(property="password", type="string", format="password"),
 * )
 */
class LoginRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|max:255|min:8',
            'password' => 'required|string|min:8'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email is required',
            'email.string' => 'Email must be a string',
            'email.max' => 'Email must less than 255 character',
            'email.email' => 'Email invalid',
            'password.required' => 'Password is required',
            'password.min' => 'Password must more than 8 char'
        ];
    }
}
