<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeacherRequest;
use App\Http\Resources\ApiResponse;
use App\Http\Resources\TeacherResponse;
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
     * @OA\Post(
     *     path="/api/v1/teachers",
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
    public function store(StoreTeacherRequest $request)
    {
        $teacher = $this->teacherService->createTeacher($request->all());


        if (!$teacher) {
            return ApiResponse::error('新增教師失敗');
        }

        return ApiResponse::success(new TeacherResponse($teacher));
    }
}
