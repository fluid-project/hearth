<?php

namespace Hearth\Tests;

use Hearth\Tests\Fixtures\User;
use Illuminate\Support\Facades\DB;

class UserTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_user_can_be_created()
    {
        $this->migrate();

        $user = $this->createUser();

        $this->assertSame(1, DB::table('users')->count());
    }

    protected function createUser()
    {
        $user = User::forceCreate([
            'name' => 'Bilbo Baggins',
            'email' => '',
            'password' => 'secret',
        ]);

        return $user;
    }

    protected function migrate()
    {
        $this->artisan('migrate', ['--database' => 'testbench'])->run();
    }
}
