<?php

namespace App\Repositories;

use App\Models\Teacher;

class TeacherRepository
{
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
