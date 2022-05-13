<?php

namespace Tests\Feature;

use App\Models\Resource;
use App\Models\ResourceCollection;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class ResourceCollectionTest extends TestCase
{
    public function test_resource_collections_can_be_translated()
    {
        if (! config('hearth.resources.enabled')) {
            return $this->markTestSkipped('Resource support is not enabled.');
        }

        $resourceCollection = ResourceCollection::factory()->create();

        $resourceCollection->setTranslation('title', 'en', 'title in English');
        $resourceCollection->setTranslation('title', 'fr', 'title in French');

        $resourceCollection->setTranslation('description', 'en', 'description in English');
        $resourceCollection->setTranslation('description', 'fr', 'description in French');

        $this->assertEquals('title in English', $resourceCollection->title);
        $this->assertEquals('description in English', $resourceCollection->description);
        App::setLocale('fr');
        $this->assertEquals('title in French', $resourceCollection->title);
        $this->assertEquals('description in French', $resourceCollection->description);

        $this->assertEquals('title in English', $resourceCollection->getTranslation('title', 'en'));
        $this->assertEquals('description in English', $resourceCollection->getTranslation('description', 'en'));
        $this->assertEquals('title in French', $resourceCollection->getTranslation('title', 'fr'));
        $this->assertEquals('description in French', $resourceCollection->getTranslation('description', 'fr'));

        $titleTranslations = ['en' => 'title in English', 'fr' => 'title in French'];
        $descriptionTranslation = ['en' => 'description in English', 'fr' => 'description in French'];

        $this->assertEquals($titleTranslations, $resourceCollection->getTranslations('title'));
        $this->assertEquals($descriptionTranslation, $resourceCollection->getTranslations('description'));

        $this->expectExceptionMessage("Cannot translate attribute `user_id` as it's not one of the translatable attributes: `title, description`");
        $resourceCollection->setTranslation('user_id', 'en', 'user_id in English');
    }

    public function test_resource_collections_belong_to_user_get_deleted_on_user_delete()
    {
        $user = User::factory()->create();
        $resourceCollection = ResourceCollection::factory()
            ->for($user)
            ->create();

        User::where('id', $user->id)->first()->delete();
        $this->assertModelMissing($resourceCollection);
    }

    public function test_many_resources_can_belong_in_single_resource_collection()
    {
        $user = User::factory()->create();

        $resourceCollection = ResourceCollection::factory()
            ->for($user)
            ->create();

        $resources = [
            Resource::factory()->create(['title' => 'first resource']),
            Resource::factory()->create(['title' => 'second resource']),
            Resource::factory()->create(['title' => 'third resource']),
        ];

        foreach ($resources as $resource) {
            $resourceCollection->resources()->sync($resource->id);
            $this->assertDatabaseHas('resource_resource_collection', [
                'resource_collection_id' => $resourceCollection->id,
                'resource_id' => $resource->id,
            ]);
        };
    }

    public function test_deleting_resource_belong_to_resource_collection()
    {
        $user = User::factory()->create();

        $resourceCollection = ResourceCollection::factory()
            ->for($user)
            ->create();

        $resource = Resource::factory()->create();

        $resourceCollection->resources()->sync($resource->id);
        $resource->delete();
        $this->assertDatabaseMissing('resource_resource_collection', [
            'resource_collection_id' => $resourceCollection->id,
            'resource_id' => $resource->id,
        ]);
    }
}
