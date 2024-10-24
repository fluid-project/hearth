<?php

namespace App\Models;

use Hearth\Traits\HasInvitations;
use Hearth\Traits\HasMembers;
use Hearth\Traits\HasRequestsToJoin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use ShiftOneLabs\LaravelCascadeDeletes\CascadesDeletes;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Organization extends Model
{
    use CascadesDeletes;
    use HasFactory;
    use HasInvitations;
    use HasMembers;
    use HasRequestsToJoin;
    use HasTranslatableSlug;
    use HasTranslations;
    use Notifiable;

    protected $fillable = [
        'name',
        'locality',
        'region',
    ];

    protected mixed $cascadeDeletes = [
        'users',
    ];

    public array $translatable = [
        'name',
        'slug',
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
     * Get the route prefix for the model.
     */
    public function getRoutePrefix(): string
    {
        return 'organizations';
    }
}
