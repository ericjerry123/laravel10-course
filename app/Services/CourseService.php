<?php

namespace App\Services;

use App\Http\Resources\ApiResponse;
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
     * @param array $data
     * @return \App\Models\Course
     */
    public function create(array $data)
    {
        return $this->courseRepository->create($data);
    }

    public function update(array $course, $id)
    {
        if (! Gate::allows('update', $course)) {
            abort(403, '您無權限更新此課程');
        }

        return $this->courseRepository->update($course, $id);
    }
}
