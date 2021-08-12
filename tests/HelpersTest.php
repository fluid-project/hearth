<?php

namespace Hearth\Tests;

class HelpersTest extends TestCase
{
    public function test_get_region_name_in_default_locale()
    {
        $result = get_region_name('NS', ['CA']);
        $this->assertEquals($result, 'Nova Scotia');
    }

    public function test_get_region_name_in_alternate_locale()
    {
        $result = get_region_name('NS', ['CA'], 'fr');
        $this->assertEquals($result, 'Nouvelle-Écosse');
    }

    public function test_get_region_name_returns_null_for_invalid_region()
    {
        $result = get_region_name('NS', ['US']);
        $this->assertNull($result);
    }

    public function test_get_regions_starts_with_blank_entry()
    {
        $result = get_regions(['CA']);
        $this->assertEquals(array_key_first($result), '');
        $this->assertEquals($result[''], '');
    }

    public function test_get_regions_in_default_locale()
    {
        $result = get_regions(['CA']);
        $this->assertEquals($result['NS'], 'Nova Scotia');
    }

    public function test_get_regions_in_alternate_locale()
    {
        $result = get_regions(['CA'], 'fr');
        $this->assertEquals($result['NS'], 'Nouvelle-Écosse');
    }

    public function test_get_region_codes()
    {
        $result = get_region_codes(['CA']);
        $this->assertContains('NS', $result);
    }
}
