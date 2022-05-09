<?php

namespace Tests\Feature;

use App\Models\Resource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class ResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_create_resources()
    {
        if (! config('hearth.resources.enabled')) {
            return $this->markTestSkipped('Resource support is not enabled.');
        }

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(localized_route('resources.create'));
        $response->assertStatus(200);

        $response = $this->actingAs($user)->post(localized_route('resources.create'), [
            'user_id' => $user->id,
            'title' => 'Test resource',
            'summary' => 'This is my resource.',
        ]);

        $url = localized_route('resources.show', ['resource' => Str::slug($user->id)]);

        $response->assertSessionHasNoErrors();

        $response->assertRedirect($url);
    }

    public function test_users_can_edit_resources_belonging_to_them()
    {
        if (! config('hearth.resources.enabled')) {
            return $this->markTestSkipped('Resource support is not enabled.');
        }

        $user = User::factory()->create();
        $resource = Resource::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(localized_route('resources.edit', $resource));
        $response->assertStatus(200);

        $response = $this->actingAs($user)->put(localized_route('resources.update', $resource), [
            'title' => $resource->title,
            'summary' => 'This is my updated resource.',
        ]);
        $response->assertRedirect(localized_route('resources.show', $resource));
    }

    public function test_users_can_translate_resources_belonging_to_them()
    {
        if (! config('hearth.resources.enabled')) {
            return $this->markTestSkipped('Resource support is not enabled.');
        }

        $user = User::factory()->create();
        $resource = Resource::factory()->create(['user_id' => $user->id]);

        $resource->setTranslation('title', 'en', 'title in English');
        $resource->setTranslation('title', 'fr', 'title in French');

        $this->assertEquals('title in English', $resource->title);
        App::setLocale('fr');
        $this->assertEquals('title in French', $resource->title);

        $this->assertEquals('title in English', $resource->getTranslation('title', 'en'));
        $this->assertEquals('title in French', $resource->getTranslation('title', 'fr'));

        $translations = ['en' => 'title in English', 'fr' => 'title in French'];

        $this->assertEquals($translations, $resource->getTranslations('title'));

        $this->expectExceptionMessage("Cannot translate attribute `user_id` as it's not one of the translatable attributes: `title, summary`");
        $resource->setTranslation('user_id', 'en', 'user_id in English');
    }

    public function test_users_can_not_edit_resources_belonging_to_others()
    {
        if (! config('hearth.resources.enabled')) {
            return $this->markTestSkipped('Resource support is not enabled.');
        }

        $user = User::factory()->create();
        $resource = Resource::factory()->create();

        $response = $this->actingAs($user)->get(localized_route('resources.edit', $resource));
        $response->assertStatus(403);

        $response = $this->actingAs($user)->put(localized_route('resources.update', $resource), [
            'title' => $resource->title,
            'summary' => 'This is my updated resource.',
        ]);
        $response->assertStatus(403);
    }

    public function test_users_can_delete_resources_belonging_to_them()
    {
        if (! config('hearth.resources.enabled')) {
            return $this->markTestSkipped('Resource support is not enabled.');
        }

        $user = User::factory()->create();
        $resource = Resource::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->from(localized_route('resources.edit', $resource))->delete(localized_route('resources.destroy', $resource), [
            'current_password' => 'password',
        ]);

        $response->assertRedirect(localized_route('dashboard'));
    }

    public function test_users_can_not_delete_resources_belonging_to_them_with_wrong_password()
    {
        if (! config('hearth.resources.enabled')) {
            return $this->markTestSkipped('Resource support is not enabled.');
        }

        $user = User::factory()->create();
        $resource = Resource::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->from(localized_route('resources.edit', $resource))->delete(localized_route('resources.destroy', $resource), [
            'current_password' => 'wrong_password',
        ]);

        $response->assertSessionHasErrors();
        $response->assertRedirect(localized_route('resources.edit', $resource));
    }

    public function test_users_can_not_delete_resources_belonging_to_others()
    {
        if (! config('hearth.resources.enabled')) {
            return $this->markTestSkipped('Resource support is not enabled.');
        }

        $user = User::factory()->create();
        $resource = Resource::factory()->create();

        $response = $this->actingAs($user)->from(localized_route('resources.edit', $resource))->delete(localized_route('resources.destroy', $resource), [
            'current_password' => 'password',
        ]);

        $response->assertStatus(403);
    }
}
