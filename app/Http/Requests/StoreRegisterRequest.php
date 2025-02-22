<?php

namespace App\Http\Requests;

use App\Http\Resources\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRegisterRequest extends FormRequest
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
            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users',
                'regex:/^[^\s]+$/'
            ],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => '用戶名稱是必填的',
            'username.unique' => '用戶名稱已存在',
            'username.regex' => '用戶名稱不能包含空格',
            'password.required' => '密碼是必填的',
            'password.min' => '密碼至少需要8個字元',
        ];
    }

    /**
     * 在驗證前處理資料
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'username' => trim($this->username),
            'password' => trim($this->password),
        ]);
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            ApiResponse::error('註冊失敗', 422, $validator->errors())
        );
    }
}
