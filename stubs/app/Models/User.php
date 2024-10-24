<?php

namespace App\Models;

use Hearth\Models\Membership;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use ShiftOneLabs\LaravelCascadeDeletes\CascadesDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class User extends Authenticatable implements HasLocalePreference, MustVerifyEmail
{
    use CascadesDeletes;
    use HasFactory;
    use HasSlug;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'locale',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected mixed $cascadeDeletes = [
        'organizations',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get the user's preferred locale.
     */
    public function preferredLocale(): string
    {
        return $this->locale;
    }

    /**
     * Get the user's resource collections.
     */
    public function resourceCollections(): HasMany
    {
        return $this->hasMany(ResourceCollection::class);
    }

    /**
     * Get the user's resources.
     */
    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    /**
     * Get the parent joinable model.
     */
    public function joinable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Has the user requested to join a model?
     *
     * @return bool
     */
    public function hasRequestedToJoin(mixed $model)
    {
        /** @var Organization */
        $joinable = $this->joinable;

        return $joinable && $joinable->id === $model->id;
    }

    /**
     * Get the organizations that belong to this user.
     */
    public function organizations(): MorphToMany
    {
        return $this->morphedByMany(Organization::class, 'membershipable', 'memberships')
            ->as('membership')
            ->using(Membership::class)
            ->withPivot(['role', 'id'])
            ->withTimestamps();
    }

    /**
     * Get the organization that belongs to the user.
     */
    public function getOrganizationAttribute(): mixed
    {
        return $this->organizations->first();
    }

    /**
     * Determine if the user is a member of a given membershipable model.
     */
    public function isMemberOf(mixed $model): bool
    {
        return $model->hasMemberWithEmail($this->email);
    }

    /**
     * Determine if the user is an administrator of a given model.
     */
    public function isAdministratorOf(mixed $model): bool
    {
        return $model->hasAdministratorWithEmail($this->email);
    }

    /**
     * Is two-factor authentication enabled for this user?
     */
    public function twoFactorAuthEnabled(): bool
    {
        return ! is_null($this->two_factor_secret);
    }
}
