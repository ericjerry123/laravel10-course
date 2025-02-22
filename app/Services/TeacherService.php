<?php

namespace App\Services;

use App\Repositories\TeacherRepository;

class TeacherService
{
    private $teacherRepository;

    public function __construct(TeacherRepository $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }

    /**
     * 新增教師
     *
     * @param array $data
     * @return \App\Models\Teacher
     */
    public function createTeacher(array $data)
    {
        return $this->teacherRepository->createTeacher($data);
    }
}
