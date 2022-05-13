<?php

namespace Hearth\Tests\Fixtures;

use Hearth\Traits\HasMembers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Organization extends Model
{
    use HasMembers;

    /**
     * Get all the members of the model.
     *
     * @return MorphToMany
     */
    public function users(): MorphToMany
    {
        return $this->morphToMany(User::class, 'membershipable', 'memberships')
            ->withPivot(['role', 'id'])
            ->withTimestamps();
    }

    /**
     * Get all the administrators of the model.
     *
     * @return MorphToMany
     */
    public function administrators(): MorphToMany
    {
        return $this->morphToMany(User::class, 'membershipable', 'memberships')
            ->wherePivot('role', 'admin')
            ->withPivot('id')
            ->withTimestamps();
    }
}
