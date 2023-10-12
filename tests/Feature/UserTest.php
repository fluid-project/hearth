<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;

test('user can be created', function () {
    User::forceCreate([
        'name' => 'Bilbo Baggins',
        'email' => '',
        'password' => 'secret',
    ]);

    expect(DB::table('users')->count())->toBe(1);
});
