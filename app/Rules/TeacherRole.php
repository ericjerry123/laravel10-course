<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TeacherRole implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = User::find($value);
        
        if (!$user || $user->role !== 'teacher') {
            $fail('所選用戶必須是教師角色。');
        }
    }
} 