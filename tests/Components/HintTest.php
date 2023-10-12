<?php

uses(\Hearth\Tests\TestCase::class);
test('hint component renders', function () {
    $view = $this->blade('<x-hearth-hint for="fname">Enter your given name.</x-hearth-hint>');

    $view->assertSee('id="fname-hint"', false);
    $view->assertSee("<p class=\"field__hint\" id=\"fname-hint\">Enter your given name.\n</p>", false);
});

test('hint component renders markdown', function () {
    $view = $this->blade('<x-hearth-hint for="fname">Enter a valid [DOI](https://www.doi.org).</x-hearth-hint>');

    $view->assertSee("<p class=\"field__hint\" id=\"fname-hint\">Enter a valid <a href=\"https://www.doi.org\">DOI</a>.\n</p>", false);
});
