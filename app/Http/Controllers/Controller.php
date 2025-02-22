<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 * title="學生選課系統", 
 * version="1.0.0",
 * description="Laravel 10 學生選課系統 API 文件"
 * )
 * 
 * @OA\Server(
 *     url="http://laravel10-course.test/",
 *     description="本地開發環境"
 * )
 * 
 * @OA\PathItem(
 *     path="/api/v1"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
