<?php

namespace App\Http\Controllers;

use App\DTO\UserDTO;
use App\Http\Requests\UserRegisterRequest;
use App\Services\PageTokenService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserService $userService;
    protected PageTokenService $pageTokenService;

    public function __construct(UserService $userService, PageTokenService $pageTokenService)
    {
        $this->userService = $userService;
        $this->pageTokenService = $pageTokenService;
    }

    public function register(UserRegisterRequest $request): JsonResponse
    {
        // +380999999999
        $user = $this->userService->register(UserDTO::from($request->validated()));
        $pageToken = $this->pageTokenService->create($user);
        return response()->json([
            'link' => route('page-tokens.page.index', ['id' => $pageToken->id])
        ]);
    }
}
