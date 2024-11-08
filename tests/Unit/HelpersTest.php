<?php

uses(\Hearth\Tests\TestCase::class);

test('get locale name', function () {
    $result = get_locale_name('fr');
    expect($result)->toEqual('French');

    $result = get_locale_name('en', 'fr');
    expect($result)->toEqual('Anglais');

    $result = get_locale_name('en', 'fr', false);
    expect($result)->toEqual('anglais');

    $result = get_locale_name('zz');
    expect($result)->toBeNull();
});
