<?php

namespace App\Services;

use App\DTO\UserDTO;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{

    public function register(UserDTO $dto): User
    {
        try {
            DB::beginTransaction();

            $user = User::create($dto->toArray());

            DB::commit();

            return $user;

        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

}
