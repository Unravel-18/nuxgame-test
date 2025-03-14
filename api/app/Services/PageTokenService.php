<?php

namespace App\Services;

use App\Models\PageToken;
use App\Models\User;

class PageTokenService
{

    public function create(User $user): PageToken
    {
        try {
            \DB::beginTransaction();

            $pageToken = new PageToken([
                'expired_at' => now()->addDays(7)
            ]);
            $pageToken->user()->associate($user);
            $pageToken->save();

            \DB::commit();

            return $pageToken;
        }catch (\Throwable $exception){
            \DB::rollBack();
            throw $exception;
        }
    }

    public function deactivate(PageToken $pageToken): PageToken
    {
        try {
            \DB::beginTransaction();

            $pageToken->update(['expired_at' => now()]);

            \DB::commit();

            return $pageToken;
        }catch (\Throwable $exception){
            \DB::rollBack();
            throw $exception;
        }
    }

    public function generateNew(PageToken $pageToken): PageToken
    {
        try {
            \DB::beginTransaction();

            $newPageToken = new PageToken([
                'expired_at' => now()->addDays(7)
            ]);
            $newPageToken->user()->associate($pageToken->user_id);
            $newPageToken->save();

            \DB::commit();

            return $newPageToken;
        }catch (\Throwable $exception){
            \DB::rollBack();
            throw $exception;
        }
    }

}
