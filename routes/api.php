<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('courses', [CourseController::class, 'index'])->name('courses.index'); // 1. 取得課程列表 API

Route::get('teachers', [TeacherController::class, 'index'])->name('teachers.index'); // 2. 授課講師 API

Route::get('teachers/{user}/courses', [TeacherController::class, 'courses'])->name('teachers.courses'); // 3. 授課課程 API

Route::post('teachers', [TeacherController::class, 'store'])->name('teachers.store'); // 4. 建立新講師 API

Route::post('courses', [CourseController::class, 'store'])->name('courses.store'); // 5. 建立新課程 API

Route::put('courses/{course}', [CourseController::class, 'update'])->name('courses.update'); // 6. 更新課程 API

Route::delete('courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy'); // 7. 刪除課程 API

require __DIR__ . '/auth.php';
