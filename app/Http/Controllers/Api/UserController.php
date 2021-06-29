<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    //返回用户列表
    public function index(): JsonResponse
    {
        //3个用户为一页
        $users = User::all();
        return $this->success(['data' => $users]);
    }

}
