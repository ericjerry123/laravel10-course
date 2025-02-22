<?php

namespace App\Http\Requests;

use App\Http\Resources\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * @OA\Schema(
 *     schema="StoreCourseRequest",
 *     required={"name", "description", "start_time", "end_time", "teacher_id"},
 *     @OA\Property(property="name", type="string", description="課程名稱", example="課程名稱"),
 *     @OA\Property(property="description", type="string", description="課程描述", example="Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo."),
 *     @OA\Property(property="start_time", type="string", description="開始時間", example="0900"),
 *     @OA\Property(property="end_time", type="string", description="結束時間", example="1000"),
 *     @OA\Property(property="teacher_id", type="integer", description="老師ID", example=1),
 * )
 */

class StoreCourseRequest extends FormRequest
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
            'description' => 'required|string',
            'start_time' => ['required', 'string', 'size:4', 'regex:/^([01][0-9]|2[0-3])([0-5][0-9])$/'],
            'end_time' => ['required', 'string', 'size:4', 'regex:/^([01][0-9]|2[0-3])([0-5][0-9])$/'],
            'teacher_id' => 'required|exists:teachers,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '課程名稱是必填的',
            'description.required' => '課程描述是必填的',
            'start_time.required' => '開始時間是必填的',
            'start_time.size' => '開始時間必須是4位數字',
            'start_time.regex' => '開始時間格式錯誤，請使用HHMM格式（例如：0900）',
            'end_time.required' => '結束時間是必填的',
            'end_time.size' => '結束時間必須是4位數字',
            'end_time.regex' => '結束時間格式錯誤，請使用HHMM格式（例如：0900）',
            'teacher_id.required' => '老師是必填的',
            'teacher_id.exists' => '老師不存在',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            ApiResponse::error('新增課程失敗', 422, $validator->errors())
        );
    }
}
