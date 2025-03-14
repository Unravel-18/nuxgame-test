<?php

namespace App\Http\Controllers;

use App\Http\Resources\LuckyAttemptResource;
use App\Models\PageToken;
use App\Services\LuckyAttemptService;
use App\Services\PageTokenService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;

class PageTokenController extends Controller
{
    protected PageTokenService $pageTokenService;
    protected LuckyAttemptService $luckyAttemptService;

    public function __construct(PageTokenService $pageTokenService, LuckyAttemptService $luckyAttemptService)
    {
        $this->luckyAttemptService = $luckyAttemptService;
        $this->pageTokenService = $pageTokenService;
    }

    public function index(string $id): View|Application|Factory
    {
        PageToken::whereDate('expired_at', '>', now())->findOrFail($id);

        return view('page', compact('id'));
    }

    public function deactivate(string $id): JsonResponse
    {
        $token = PageToken::whereDate('expired_at', '>', now())->findOrFail($id);

        $this->pageTokenService->deactivate($token);
        return response()->json([
            'messages' => 'success'
        ]);
    }

    public function generateNew(string $id): JsonResponse
    {
        $token = PageToken::whereDate('expired_at', '>', now())->findOrFail($id);

        $newToken = $this->pageTokenService->generateNew($token);
        return response()->json([
            'link' => route('page-tokens.page.index', ['id' => $newToken->id])
        ]);
    }

    public function attemptLucky(string $id): JsonResponse
    {
        $token = PageToken::whereDate('expired_at', '>', now())->findOrFail($id);

        $luckyAttempt = $this->luckyAttemptService->attemptLucky($token);

        return response()->json([
            'data' => LuckyAttemptResource::make($luckyAttempt)
        ]);
    }

    public function getAttemptLuckyHistory(string $id): JsonResponse
    {
        $token = PageToken::whereDate('expired_at', '>', now())->findOrFail($id);
        $luckyAttempts = $token->luckyAttempts()->orderByDesc('created_at')->take(3)->get();
        return response()->json([
            'data' => LuckyAttemptResource::collection($luckyAttempts)
        ]);
    }
}
