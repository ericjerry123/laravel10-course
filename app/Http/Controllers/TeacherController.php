<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegisterRequest;
use App\Http\Resources\ApiResponse;
use App\Http\Resources\CourseResource;
use App\Http\Resources\TeacherResponse;
use App\Models\User;
use App\Services\TeacherService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="教師",
 *     description="教師相關操作"
 * )
 */
class TeacherController extends Controller
{
    private $teacherService;

    public function __construct(TeacherService $teacherService)
    {
        $this->teacherService = $teacherService;
    }

    /**
     * @OA\Get(
     *     path="/api/teachers",
     *     summary="取得所有教師",
     *     tags={"教師"},
     *     @OA\Response(
     *         response=200,
     *         description="教師列表",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Eric"),
     *                     @OA\Property(property="email", type="string", example="test@example.com")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="伺服器錯誤",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=500),
     *             @OA\Property(property="message", type="string", example="伺服器錯誤"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $teachers = $this->teacherService->getAllTeachers();

        if ($teachers->isEmpty()) return ApiResponse::error('找不到教師');

        return ApiResponse::success(TeacherResponse::collection($teachers));
    }

    /**
     * @OA\Post(
     *     path="/api/teachers",
     *     summary="新增教師",
     *     tags={"教師"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Eric"),
     *             @OA\Property(property="email", type="string", format="email", example="test@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="教師新增成功",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=201),
     *             @OA\Property(property="message", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Eric"),
     *                 @OA\Property(property="email", type="string", example="test@example.com")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="教師新增失敗",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=422),
     *             @OA\Property(property="message", type="string", example="新增教師失敗"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="name", type="array", @OA\Items(type="string"), example={"姓名是必填的"}),
     *                 @OA\Property(property="email", type="array", @OA\Items(type="string"), example={"Email 格式錯誤", "Email 已存在"})
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="伺服器錯誤",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=500),
     *             @OA\Property(property="message", type="string", example="伺服器錯誤"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function store(StoreRegisterRequest $request)
    {
        $teacher = $this->teacherService->createTeacher($request->all());

        if (!$teacher) {
            return ApiResponse::error('新增教師失敗');
        }

        return ApiResponse::success(new TeacherResponse($teacher));
    }

    /**
     * @OA\Get(
     *     path="/api/teachers/{user}/courses",
     *     summary="取得指定教師的課程列表",
     *     tags={"教師"},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         description="教師ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="課程列表",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="PHP基礎課程"),
     *                     @OA\Property(property="description", type="string", example="學習PHP的基礎知識"),
     *                     @OA\Property(property="start_date", type="string", format="date", example="2024-03-20"),
     *                     @OA\Property(property="end_date", type="string", format="date", example="2024-06-20")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="找不到教師",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=404),
     *             @OA\Property(property="message", type="string", example="找不到教師"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="伺服器錯誤",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=500),
     *             @OA\Property(property="message", type="string", example="伺服器錯誤"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function courses(User $user)
    {
        $courses = $this->teacherService->getCoursesByTeacher($user);

        return ApiResponse::success(CourseResource::collection($courses));
    }
}
