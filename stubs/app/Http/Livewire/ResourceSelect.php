<?php

namespace App\Http\Livewire;

use App\Models\Resource;
use App\Models\ResourceCollection;
use Livewire\Component;

class ResourceSelect extends Component
{
    public array $availableResources = [];

    public array $selectedResources = [];

    public function mount(?int $resourceCollectionId)
    {
        if ($resourceCollectionId != null) {
            $resourcesInCollection = ResourceCollection::where('id', $resourceCollectionId)
                ->first()
                ->resources()
                ->get();

            $resourceIdsInCollection = [];
            foreach ($resourcesInCollection as $resource) {
                array_push($resourceIdsInCollection, $resource->id);
            }

            foreach (Resource::orderBy('title')->get() as $resource) {
                if (in_array($resource->id, $resourceIdsInCollection, true)) {
                    $this->selectedResources[] = $resource->toArray();
                } else {
                    $this->availableResources[] = $resource->toArray();
                }
            }
        } else {
            foreach (Resource::orderBy('title')->get() as $resource) {
                $this->availableResources[] = $resource->toArray();
            }
        }
    }

    public function addResource(int $i): void
    {
        if ($this->availableResources[$i]) {
            $this->selectedResources[] = $this->availableResources[$i];
            array_splice($this->availableResources, $i, 1);
        }
    }

    public function removeResource(int $i): void
    {
        if ($this->selectedResources[$i]) {
            $this->availableResources[] = $this->selectedResources[$i];
            array_splice($this->selectedResources, $i, 1);
        }
    }

    public function render()
    {
        return view('livewire.resource-select');
    }
}
