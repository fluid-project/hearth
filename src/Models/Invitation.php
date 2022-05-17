<?php

namespace Hearth\Models;

use App\Models\User;
use Database\Factories\InvitationFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Hearth\Models\Invitation
 *
 * @property string $email
 * @property string $role
 * @property mixed $invitationable
 */
class Invitation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'email',
        'role',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return InvitationFactory::new();
    }

    /**
     * Get the parent invitationable model.
     */
    public function invitationable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Accept an invitation.
     *
     * @return void
     */
    public function accept(): void
    {
        $invitee = User::where('email', $this->email)->first();

        $this->invitationable->users()->attach(
            $invitee,
            ['role' => $this->role]
        );
    }
}
