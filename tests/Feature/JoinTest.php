<?php

namespace Hearth\Tests\Feature;

use App\Models\Organization;
use App\Models\User;
use Hearth\Tests\TestCase;
use Illuminate\Support\Facades\Schema;

class JoinTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        Schema::dropAllTables();

        $create_users_table = include __DIR__.'/../../database/migrations/create_users_table.php.stub';
        $update_users_table = include __DIR__.'/../../database/migrations/update_users_table.php.stub';
        $add_joinable_columns = include __DIR__.'/../../database/migrations/2021_03_01_000000_add_joinable_columns_to_users_table.php';
        $create_organizations_table = include __DIR__.'/../../database/migrations/create_organizations_table.php.stub';
        $create_users_table->up();
        $update_users_table->up();
        $add_joinable_columns->up();
        $create_organizations_table->up();
    }

    public function test_user_can_have_join_request_for_organization()
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

        $organization->requestsToJoin()->save($user);

        $this->assertEquals(1, $organization->requestsToJoin->count());
        $this->assertEquals($user->id, $organization->requestsToJoin->first()->id);
    }
}
