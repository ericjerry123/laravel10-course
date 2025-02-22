<?php

namespace App\Repositories;

use App\Models\Teacher;

class TeacherRepository
{
    /**
     * 取得所有教師
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllTeachers()
    {
        return Teacher::all();
    }

    /**
     * 新增教師
     *
     * @param array $data
     * @return \App\Models\Teacher
     */
    public function createTeacher(array $data)
    {
        return Teacher::create($data);
    }
}
