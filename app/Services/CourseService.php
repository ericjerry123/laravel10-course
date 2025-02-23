<?php

namespace App\Services;

use App\Models\Course;
use App\Repositories\CourseRepository;
use Illuminate\Support\Facades\Gate;

class CourseService
{
    private $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    /**
     * 取得所有課程
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return $this->courseRepository->getAll();
    }

    /**
     * 新增課程
     *
     * @param array $course
     * @return \App\Models\Course
     */
    public function create(array $course)
    {
        return $this->courseRepository->create($course);
    }

    /**
     * 更新課程
     *
     * @param array $newCourse
     * @param \App\Models\Course $oldCourse
     * @return \App\Models\Course
     */
    public function update(array $newCourse, Course $oldCourse)
    {
        return $this->courseRepository->update($newCourse, $oldCourse);
    }

    /**
     * 刪除課程
     *
     * @param \App\Models\Course $course
     * @return \App\Models\Course
     */
    public function delete(Course $course)
    {
        return $this->courseRepository->delete($course);
    }
}
