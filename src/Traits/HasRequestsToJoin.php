<?php

namespace Hearth\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasRequestsToJoin
{
    /**
     * Get all the model's requests to join.
     *
     * @return MorphMany
     */
    public function requestsToJoin(): MorphMany
    {
        return $this->morphMany(User::class, 'joinable');
    }
}
