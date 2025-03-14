<?php

namespace App\Http\Controllers;

use App\Models\PageToken;
use App\Services\LuckyAttemptService;
use App\Services\PageTokenService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class HomeController extends Controller
{

    public function index(): View|Application|Factory
    {
        return view('home');
    }

}
