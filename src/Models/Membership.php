<?php

namespace Hearth\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Membership extends MorphPivot
{
    /**
     * The table associated with the pivot model.
     *
     * @var string
     */
    protected $table = 'memberships';

    /**
     * Return the parent user of the membership.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Retrieve the parent model of the membership.
     *
     * @return mixed
     */
    public function membershipable(): mixed
    {
        return $this->membershipable_type::where('id', $this->membershipable_id)->first();
    }
}
