<?php

namespace App\Repositories;

use App\Http\Resources\CourseResource;
use App\Models\Course;

class CourseRepository
{
    /**
     * 取得所有課程
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        $courses = Course::with('teacher')->limit(2)->get();

        return CourseResource::collection($courses);
    }

    /**
     * 新增課程
     *
     * @param array $courses
     * @return \App\Models\Course
     */
    public function create(array $courses)
    {
        $course = Course::create($courses);
        
        return new CourseResource($course);
    }

    /**
     * 更新課程
     *
     * @param array $courses
     * @param \App\Models\Course $course
     * @return CourseResource
     */
    public function update(array $newCourse, Course $oldCourse)
    {
        $oldCourse->update($newCourse);
        return new CourseResource($oldCourse->fresh());
    }

    /**
     * 刪除課程
     *
     * @param \App\Models\Course $course
     * @return \App\Models\Course
     */
    public function delete(Course $course)
    {
        return $course->delete();
    }
}
