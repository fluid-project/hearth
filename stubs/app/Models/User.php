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

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'locale',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The relationships that should be deleted when a user is deleted.
     *
     * @var array
     */
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
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get the user's preferred locale.
     *
     * @return string
     */
    public function preferredLocale(): string
    {
        return $this->locale;
    }

    /**
     * Get the user's resource collections.
     *
     * @return HasMany
     */
    public function resourceCollections(): HasMany
    {
        return $this->hasMany(ResourceCollection::class);
    }

    /**
     * Get the parent joinable model.
     *
     * @return MorphTo
     */
    public function joinable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Has the user requested to join a model?
     *
     * @param  mixed  $model
     * @return bool
     */
    public function hasRequestedToJoin(mixed $model)
    {
        return $this->joinable && $this->joinable->id === $model->id;
    }

    /**
     * Get the organizations that belong to this user.
     *
     * @return MorphToMany
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
     *
     * @return mixed
     */
    public function getOrganizationAttribute(): mixed
    {
        return $this->organizations->first();
    }

    /**
     * Determine if the user is a member of a given membershipable model.
     *
     * @param  mixed  $model
     * @return bool
     */
    public function isMemberOf(mixed $model): bool
    {
        return $model->hasMemberWithEmail($this->email);
    }

    /**
     * Determine if the user is an administrator of a given model.
     *
     * @param  mixed  $model
     * @return bool
     */
    public function isAdministratorOf(mixed $model): bool
    {
        return $model->hasAdministratorWithEmail($this->email);
    }

    /**
     * Is two-factor authentication enabled for this user?
     *
     * @return bool
     */
    public function twoFactorAuthEnabled(): bool
    {
        return ! is_null($this->two_factor_secret);
    }
}
