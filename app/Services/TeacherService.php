<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\TeacherRepository;

class TeacherService
{
    private $teacherRepository;

    public function __construct(TeacherRepository $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }

    /**
     * 取得所有教師
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllTeachers()
    {
        return $this->teacherRepository->getAllTeachers();
    }

    /**
     * 新增教師
     *
     * @param array $credentials
     * @return \App\Models\Teacher
     */
    public function createTeacher(array $credentials)
    {
        $credentials['role'] = 'teacher';

        return $this->teacherRepository->createTeacher($credentials);
    }

    public function getCoursesByTeacher(User $user)
    {
        return $this->teacherRepository->getCoursesByTeacher($user);
    }
}
