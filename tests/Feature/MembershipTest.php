<?php

namespace Hearth\Tests\Feature;

use Hearth\Models\Membership;
use App\Models\Organization;
use App\Models\User;
use Hearth\Tests\TestCase;
use Illuminate\Support\Facades\Schema;

class MembershipTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        Schema::dropAllTables();

        $create_users_table = include __DIR__ . '/../../database/migrations/create_users_table.php.stub';
        $update_users_table = include __DIR__ . '/../../database/migrations/update_users_table.php.stub';
        $create_memberships_table = include __DIR__ . '/../../database/migrations/2021_03_01_000000_create_memberships_table.php';
        $create_organizations_table = include __DIR__ . '/../../database/migrations/create_organizations_table.php.stub';

        $create_users_table->up();
        $update_users_table->up();
        $create_memberships_table->up();
        $create_organizations_table->up();
    }

    public function test_membership_can_be_created_for_organization()
    {
        $user = User::forceCreate([
            'name' => 'Frodo Baggins',
            'email' => 'frodo@bag-end.net',
            'password' => 'secret',
        ]);

        $organization = Organization::forceCreate([
            'name' => json_encode(['en' => 'Fellowship']),
            'locality' => 'Rivendell',
            'region' => 'BC',
        ]);

        $organization->users()->attach($user, ['role' => 'admin']);

        $membership = Membership::where('id', $organization->users->first()->membership->id)->first();

        $this->assertEquals(1, $organization->users()->count());
        $this->assertEquals(1, $organization->administrators()->count());
        $this->assertTrue($organization->hasUserWithEmail($user->email));
        $this->assertTrue($organization->hasAdministratorWithEmail($user->email));
        $this->assertEquals($membership->membershipable_type, get_class($organization));
        $this->assertEquals($membership->membershipable_id, $organization->id);
        $this->assertEquals($organization->id, $membership->membershipable()->id);
        $this->assertEquals($user->id, $membership->user->id);
    }
}
