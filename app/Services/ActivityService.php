<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ActivityService
{
    public function search(array $filters, int $perPage = 10): LengthAwarePaginator
    {
        return Activity::filter($filters)
            ->orderBy('start_day')
            ->paginate($perPage);
    }
}
