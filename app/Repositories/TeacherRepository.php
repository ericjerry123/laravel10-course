<?php

namespace App\Repositories;

use App\Models\User;

class TeacherRepository
{
    /**
     * 取得所有教師
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllTeachers()
    {
        return User::where('role', 'teacher')->get();
    }

    /**
     * 新增教師
     *
     * @param array $credentials
     * @return \App\Models\User
     */
    public function createTeacher(array $credentials)
    {
        return User::create($credentials);
    }

    public function getCoursesByTeacher(User $teacher)
    {
        return $teacher->courses;
    }
}
