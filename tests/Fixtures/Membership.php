<?php

namespace Hearth\Tests\Fixtures;

use Hearth\Models\Membership as HearthMembership;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Membership extends HearthMembership
{
    /**
     * Return the parent user of the membership.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
