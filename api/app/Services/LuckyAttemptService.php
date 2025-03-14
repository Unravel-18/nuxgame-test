<?php

namespace App\Services;

use App\DTO\UserDTO;
use App\Models\LuckyAttempt;
use App\Models\PageToken;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LuckyAttemptService
{
    public function attemptLucky(PageToken $pageToken): LuckyAttempt
    {
        $randNumber = rand(1, 1000);
        $isWinner = $randNumber % 2 == 0;
        $winSum = $isWinner ? $this->calculateWinnerSum($randNumber) : 0;
        try {
            DB::beginTransaction();

            $luckyAttempt = new LuckyAttempt([
                'rand_number' => $randNumber,
                'winner_sum' => $winSum,
                'is_winner' => $isWinner,
            ]);
            $luckyAttempt->pageToken()->associate($pageToken);
            $luckyAttempt->save();

            DB::commit();

            return $luckyAttempt;
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    protected function calculateWinnerSum(int $randNumber): float
    {
        $winnerSum = match (true) {
            $randNumber > 900 => $randNumber * 0.7,
            $randNumber > 600 => $randNumber * 0.5,
            $randNumber > 300 => $randNumber * 0.3,
            default => $randNumber * 0.1,

        };
        return round($winnerSum,2);
    }

}
