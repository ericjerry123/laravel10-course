<?php

namespace App\Http\Requests;

use App\Http\Resources\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreTeacherRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email|unique:teachers',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '姓名是必填的',
            'email.required' => 'Email 是必填的',
            'email.email' => 'Email 格式錯誤',
            'email.unique' => 'Email 已存在',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            ApiResponse::error('新增教師失敗', 422, $validator->errors())
        );
    }
}
