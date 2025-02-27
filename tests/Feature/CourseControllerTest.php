<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $courseData;

    protected function setUp(): void
    {
        parent::setUp();
        
        // 創建老師角色的測試用戶
        $this->user = User::factory()->teacher()->create();
        
        // 準備測試數據
        $this->courseData = [
            'name' => '測試課程',
            'description' => '這是一個測試課程',
            'start_time' => '0900',
            'end_time' => '1030',
            'user_id' => $this->user->id
        ];
    }

    /** @test */
    public function can_get_course_list()
    {
        // 創建測試課程
        Course::factory()->count(3)->create();

        // 發送請求
        $response = $this->getJson('/api/courses');

        // 驗證響應
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'start_time',
                        'end_time'
                    ]
                ],
                'message',
                'status'
            ]);
    }

    /** @test */
    public function can_create_course()
    {
        $response = $this->postJson('/api/courses', $this->courseData);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'name' => '測試課程',
                'description' => '這是一個測試課程',
                'start_time' => '0900',
                'end_time' => '1030'
            ]);

        $this->assertDatabaseHas('courses', [
            'name' => '測試課程'
        ]);
    }

    /** @test */
    public function can_update_course()
    {
        // 創建一個課程
        $course = Course::factory()->create();

        $updatedData = $this->courseData;
        $updatedData['name'] = '更新後的課程名稱';

        $response = $this->putJson("/api/courses/{$course->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => '更新後的課程名稱'
            ]);

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'name' => '更新後的課程名稱'
        ]);
    }

    /** @test */
    public function can_delete_course()
    {
        $course = Course::factory()->create();

        $response = $this->deleteJson("/api/courses/{$course->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('courses', [
            'id' => $course->id
        ]);
    }

    /** @test */
    public function cannot_create_course_with_invalid_data()
    {
        $invalidData = [
            'name' => '', 
            'description' => '',
            'start_time' => 'invalid_time',
            'end_time' => 'invalid_time',
            'user_id' => 999999
        ];

        $response = $this->postJson('/api/courses', $invalidData);

        $response->assertStatus(422)
            ->assertJson([
                'data' => [
                    'name' => ['課程名稱是必填的'],
                    'description' => ['課程描述是必填的'],
                    'start_time' => [
                        '開始時間必須是4位數字',
                        '開始時間格式錯誤，請使用HHMM格式（例如：0900）'
                    ],
                    'end_time' => [
                        '結束時間必須是4位數字',
                        '結束時間格式錯誤，請使用HHMM格式（例如：0900）'
                    ],
                    'user_id' => [
                        '老師不存在',
                        '所選用戶必須是教師角色。'
                    ]
                ],
                'message' => '新增課程失敗',
                'status' => 422
            ]);
    }
} 