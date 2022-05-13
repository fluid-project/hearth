<?php

namespace Hearth\Tests\Feature;

use App\Models\Organization;
use App\Models\User;
use Hearth\Models\Invitation;

use Hearth\Tests\TestCase;
use Illuminate\Support\Facades\Schema;

class InvitationTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        Schema::dropAllTables();

        $create_users_table = include __DIR__ . '/../../database/migrations/create_users_table.php.stub';
        $update_users_table = include __DIR__ . '/../../database/migrations/update_users_table.php.stub';
        $create_invitations_table = include __DIR__ . '/../../database/migrations/2021_03_01_000000_create_invitations_table.php';
        $create_organizations_table = include __DIR__ . '/../../database/migrations/create_organizations_table.php.stub';

        $create_users_table->up();
        $update_users_table->up();
        $create_invitations_table->up();
        $create_organizations_table->up();
    }

    public function test_invitation_can_be_created_for_organization()
    {
        $user = User::forceCreate([
            'name' => 'Frodo Baggins',
            'email' => 'frodo@bag-end.net',
            'password' => 'secret',
        ]);

        $otherUser = User::forceCreate([
            'name' => 'Samwise Gamgee',
            'email' => 'sam@bag-end.net',
            'password' => 'secret',
        ]);

        $organization = Organization::forceCreate([
            'name' => json_encode(['en' => 'Fellowship']),
            'locality' => 'Rivendell',
            'region' => 'BC',
        ]);

        $invitation = Invitation::forceCreate([
            'invitationable_id' => $organization->id,
            'invitationable_type' => get_class($organization),
            'email' => $user->email,
            'role' => 'admin',
        ]);

        $otherInvitation = Invitation::forceCreate([
            'invitationable_id' => $organization->id,
            'invitationable_type' => get_class($organization),
            'email' => $otherUser->email,
            'role' => 'member',
        ]);

        $this->assertEquals(2, $organization->invitations->count());
        $this->assertEquals($organization->id, $invitation->invitationable->id);
    }
}
