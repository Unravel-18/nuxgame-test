<?php

namespace App\Http\Resources;

use App\Models\LuckyAttempt;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LuckyAttemptCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var LuckyAttempt $resource */
        $resource = $this->resource;
        return [
            'is_winner' => $resource->is_winner,
            'winner_sum' => $resource->winner_sum,
            'rand_number' => $resource->rand_number,
            'created_at' => $resource->created_at
        ];
    }
}
