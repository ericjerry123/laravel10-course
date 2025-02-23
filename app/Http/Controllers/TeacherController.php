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
     *     summary="教師列表",
     *     tags={"教師"},
     *     @OA\Response(
     *         response=200,
     *         description="教師列表",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Eric"),
     *                     @OA\Property(property="email", type="string", example="test@example.com")
     *                 ),
     *                 example={
     *                     {
     *                         "id": 1,
     *                         "name": "Eric",
     *                         "email": "test@example.com"
     *                     },
     *                     {
     *                         "id": 2,
     *                         "name": "Mary",
     *                         "email": "mary@example.com"
     *                     }
     *                 }
     *             ),
     *             @OA\Property(property="message", type="string", example="success"),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="找不到教師",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="message", type="string", example="找不到教師"),
     *             @OA\Property(property="status", type="integer", example=404)
     *         )
     *     )
     * )
     */
    public function index()
    {
        $teachers = $this->teacherService->getAllTeachers();
        if ($teachers->isEmpty()) return ApiResponse::error('找不到教師', 404);
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
     *             required={"name","username","password"},
     *             @OA\Property(property="name", type="string", example="Eric", description="教師姓名"),
     *             @OA\Property(property="username", type="string", example="eric", description="登入帳號"),
     *             @OA\Property(property="password", type="string", example="12345678", description="登入密碼")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="教師新增成功",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Eric"),
     *                 @OA\Property(property="email", type="string", example="test@example.com")
     *             ),
     *             @OA\Property(property="message", type="string", example="success"),
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
     *                 @OA\Property(property="name", type="array", @OA\Items(type="string", example="姓名是必填的")),
     *                 @OA\Property(property="username", type="array", @OA\Items(type="string", example={"用戶名稱是必填的", "用戶名稱已存在"})),
     *                 @OA\Property(property="password", type="array", @OA\Items(type="string", example="密碼至少需要8個字元"))
     *             ),
     *             @OA\Property(property="message", type="string", example="新增教師失敗"),
     *             @OA\Property(property="status", type="integer", example=422)
     *         )
     *     )
     * )
     */
    public function store(StoreRegisterRequest $request)
    {
        $teacher = $this->teacherService->createTeacher($request->all());
        if (!$teacher) {
            return ApiResponse::error('新增教師失敗', 422);
        }
        return ApiResponse::success(new TeacherResponse($teacher), 'success', 201);
    }

    /**
     * @OA\Get(
     *     path="/api/teachers/{user}/courses",
     *     summary="教師課程列表",
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
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="找不到教師",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="message", type="string", example="找不到教師"),
     *             @OA\Property(property="status", type="integer", example=404)
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
