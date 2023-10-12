<?php

use App\Http\Livewire\ResourceSelect;
use App\Models\Resource;
use App\Models\ResourceCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('resource select when resource collection id parameter is null', function () {
    if (! config('hearth.resources.enabled')) {
        return $this->markTestSkipped('Resource support is not enabled.');
    }

    $resources = Resource::factory(5)->create();
    $resourceSelect = Livewire::test(ResourceSelect::class, ['resourceCollectionId' => null]);
    expect(5)->toEqual(count($resourceSelect->availableResources));
    expect(0)->toEqual(count($resourceSelect->selectedResources));

    $resourceIds = [];
    foreach ($resources as $resource) {
        $resourceIds[] = $resource->id;
    }
    foreach ($resourceSelect->availableResources as $availableResource) {
        expect(in_array($availableResource['id'], $resourceIds, true))->toBeTrue();
    }
});

test('resource select when resource collection id parameter is not null', function () {
    if (! config('hearth.resources.enabled')) {
        return $this->markTestSkipped('Resource support is not enabled.');
    }

    $resourceCollection = ResourceCollection::factory()->create();
    $selectedResources = Resource::factory(5)->create();
    $resourceCollection->resources()->attach($selectedResources);

    $availableResources = Resource::factory(3)->create();
    $resourceSelect = Livewire::test(ResourceSelect::class, ['resourceCollectionId' => $resourceCollection->id]);
    expect(3)->toEqual(count($resourceSelect->availableResources));
    expect(5)->toEqual(count($resourceSelect->selectedResources));

    $selectedResourceIds = [];
    foreach ($selectedResources as $selectedResource) {
        $selectedResourceIds[] = $selectedResource->id;
    }
    foreach ($resourceSelect->selectedResources as $selectedResource) {
        expect(in_array($selectedResource['id'], $selectedResourceIds, true))->toBeTrue();
    }

    $availableResourceIds = [];
    foreach ($availableResources as $availableResource) {
        $availableResourceIds[] = $availableResource->id;
    }
    foreach ($resourceSelect->availableResources as $availableResource) {
        expect(in_array($availableResource['id'], $availableResourceIds, true))->toBeTrue();
    }
});

test('add resource', function () {
    if (! config('hearth.resources.enabled')) {
        return $this->markTestSkipped('Resource support is not enabled.');
    }

    $resources = Resource::factory(5)->create();
    $resourceSelect = Livewire::test(ResourceSelect::class, ['resourceCollectionId' => null]);
    $sampleAvailableResource = $resourceSelect->availableResources->first();

    expect(5)->toEqual(count($resourceSelect->availableResources));
    expect(0)->toEqual(count($resourceSelect->selectedResources));

    $resourceSelect->call('addResource', $sampleAvailableResource->id);

    expect($resourceSelect->selectedResources->pluck('id')->toArray())->toContain($sampleAvailableResource->id);

    expect(4)->toEqual(count($resourceSelect->availableResources));
    expect(1)->toEqual(count($resourceSelect->selectedResources));
});

test('remove resource', function () {
    if (! config('hearth.resources.enabled')) {
        return $this->markTestSkipped('Resource support is not enabled.');
    }

    $resourceCollection = ResourceCollection::factory()->create();
    $selectedResources = Resource::factory(5)->create();
    $resourceCollection->resources()->attach($selectedResources);

    $availableResources = Resource::factory(3)->create();
    $resourceSelect = Livewire::test(ResourceSelect::class, ['resourceCollectionId' => $resourceCollection->id]);
    $sampleSelectedResource = $resourceSelect->selectedResources->first();

    expect(3)->toEqual(count($resourceSelect->availableResources));
    expect(5)->toEqual(count($resourceSelect->selectedResources));

    $resourceSelect->call('removeResource', $sampleSelectedResource->id);

    expect($resourceSelect->availableResources->pluck('id')->toArray())->toContain($sampleSelectedResource->id);

    expect(4)->toEqual(count($resourceSelect->availableResources));
    expect(4)->toEqual(count($resourceSelect->selectedResources));
});
