<?php

namespace Hearth\Tests\Feature;

use App\Models\User;
use Hearth\Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getEnvironmentSetUp($app)
    {
        Schema::dropAllTables();

        $create_users_table = include __DIR__ . '/../../database/migrations/create_users_table.php.stub';
        $update_users_table = include __DIR__ . '/../../database/migrations/update_users_table.php.stub';

        $create_users_table->up();
        $update_users_table->up();
    }

    public function test_user_can_be_created()
    {
        $this->migrate();

        $user = $this->createUser();

        $this->assertSame(1, DB::table('users')->count());
    }

    protected function createUser()
    {
        return User::forceCreate([
            'name' => 'Bilbo Baggins',
            'email' => '',
            'password' => 'secret',
        ]);
    }

    protected function migrate()
    {
        $this->artisan('migrate')->run();
    }
}
