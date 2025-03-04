<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Resources\ApiResponse;
use App\Models\Course;
use App\Services\CourseService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="課程",
 *     description="課程相關操作"
 * )
 */
class CourseController extends Controller
{
    private $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    /**
     * @OA\Get(
     *     path="/api/courses",
     *     summary="課程列表",
     *     tags={"課程"},
     *     @OA\Response(
     *         response=200,
     *         description="課程列表",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="中級英文"),
     *                     @OA\Property(property="description", type="string", example="中級英文課程，適合初學者"),
     *                     @OA\Property(property="start_time", type="string", example="0900"),
     *                     @OA\Property(property="end_time", type="string", example="1030")
     *                 ),
     *                 example={
     *                     {
     *                         "id": 1,
     *                         "name": "中級英文",
     *                         "description": "中級英文課程，適合初學者",
     *                         "start_time": "0900",
     *                         "end_time": "1030"
     *                     },
     *                     {
     *                         "id": 2,
     *                         "name": "程式設計入門",
     *                         "description": "學習基礎程式設計概念",
     *                         "start_time": "1400",
     *                         "end_time": "1530"
     *                     }
     *                 }
     *             ),
     *             @OA\Property(property="message", type="string", example="success"),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     )
     * )
     */
    public function index()
    {
        $courses = $this->courseService->getAll();
        return ApiResponse::success($courses, '課程列表', 200);
    }

    /**
     * @OA\Post(
     *     path="/api/courses",
     *     summary="新增課程",
     *     tags={"課程"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="課程資料",
     *         @OA\JsonContent(
     *             required={"name","description","start_time","end_time","user_id"},
     *             @OA\Property(property="name", type="string", example="程式設計入門", description="課程名稱"),
     *             @OA\Property(property="description", type="string", example="學習基礎程式設計概念", description="課程描述"),
     *             @OA\Property(property="start_time", type="string", example="0900", description="開始時間（24小時制）"),
     *             @OA\Property(property="end_time", type="string", example="1030", description="結束時間（24小時制）"),
     *             @OA\Property(property="user_id", type="integer", example=1, description="教師ID")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="課程新增成功",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="程式設計入門"),
     *                 @OA\Property(property="description", type="string", example="學習基礎程式設計概念"),
     *                 @OA\Property(property="start_time", type="string", example="0900"),
     *                 @OA\Property(property="end_time", type="string", example="1030")
     *             ),
     *             @OA\Property(property="message", type="string", example="新增課程成功"),
     *             @OA\Property(property="status", type="integer", example=201)
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="驗證失敗",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="name", type="array", @OA\Items(type="string", example="課程名稱是必填的")),
     *                 @OA\Property(property="description", type="array", @OA\Items(type="string", example="課程描述是必填的")),
     *                 @OA\Property(property="start_time", type="array", @OA\Items(type="string", example="開始時間是必填的")),
     *                 @OA\Property(property="end_time", type="array", @OA\Items(type="string", example="結束時間是必填的")),
     *                 @OA\Property(property="user_id", type="array", @OA\Items(type="string", example="老師是必填的"))
     *             ),
     *             @OA\Property(property="message", type="string", example="新增課程失敗"),
     *             @OA\Property(property="status", type="integer", example=422)
     *         )
     *     )
     * )
     */
    public function store(StoreCourseRequest $request)
    {
        $course = $this->courseService->create($request->validated());

        if (!$course) {
            return ApiResponse::error('新增課程失敗');
        }

        return ApiResponse::success($course, '新增課程成功', 201);
    }

    /**
     * @OA\Put(
     *     path="/api/courses/{course}",
     *     summary="更新課程",
     *     tags={"課程"},
     *     @OA\Parameter(
     *         name="course",
     *         in="path",
     *         required=true,
     *         description="課程 ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="課程資料",
     *         @OA\JsonContent(
     *             required={"name","description","start_time","end_time","user_id"},
     *             @OA\Property(property="name", type="string", example="中級英文", description="課程名稱"),
     *             @OA\Property(property="description", type="string", example="中級英文課程，適合初學者", description="課程描述"),
     *             @OA\Property(property="start_time", type="string", example="0900", description="開始時間（24小時制）"),
     *             @OA\Property(property="end_time", type="string", example="1030", description="結束時間（24小時制）"),
     *             @OA\Property(property="user_id", type="integer", example=1, description="教師ID")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="課程更新成功",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="中級英文"),
     *                 @OA\Property(property="description", type="string", example="中級英文課程，適合初學者"),
     *                 @OA\Property(property="start_time", type="string", example="0900"),
     *                 @OA\Property(property="end_time", type="string", example="1030")
     *             ),
     *             @OA\Property(property="message", type="string", example="更新課程成功"),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="驗證失敗",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="name", type="array", @OA\Items(type="string", example="課程名稱是必填的")),
     *                 @OA\Property(property="description", type="array", @OA\Items(type="string", example="課程描述是必填的")),
     *                 @OA\Property(property="start_time", type="array", @OA\Items(type="string", example="開始時間是必填的")),
     *                 @OA\Property(property="end_time", type="array", @OA\Items(type="string", example="結束時間是必填的")),
     *                 @OA\Property(property="user_id", type="array", @OA\Items(type="string", example="老師是必填的"))
     *             ),
     *             @OA\Property(property="message", type="string", example="更新課程失敗"),
     *             @OA\Property(property="status", type="integer", example=422)
     *         )
     *     )
     * )
     */
    public function update(StoreCourseRequest $request, Course $course)
    {
        $course = $this->courseService->update($request->validated(), $course);

        return ApiResponse::success($course, '更新課程成功', 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/courses/{course}",
     *     summary="刪除課程",
     *     tags={"課程"},
     *     @OA\Parameter(
     *         name="course",
     *         in="path",
     *         required=true,
     *         description="課程 ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="課程刪除成功",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="null",
     *                 example=null
     *             ),
     *             @OA\Property(property="message", type="string", example="刪除課程成功"),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="找不到課程",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="message", type="string", example="找不到課程"),
     *             @OA\Property(property="status", type="integer", example=404)
     *         )
     *     )
     * )
     */
    public function destroy(Course $course)
    {
        $this->courseService->delete($course);

        return ApiResponse::success(null, '刪除課程成功', 200);
    }
}
