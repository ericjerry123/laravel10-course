<?php

namespace App\Repositories;

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
        return Course::all();
    }

    /**
     * 新增課程
     *
     * @param array $data
     * @return \App\Models\Course
     */
    public function create(array $data)
    {
        return Course::create($data);
    }
}
