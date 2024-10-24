<?php

namespace App\Http\Livewire;

use App\Models\Resource;
use App\Models\ResourceCollection;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ResourceSelect extends Component
{
    public Collection $availableResources;

    public Collection $selectedResources;

    public string $message = '';

    public function mount(?int $resourceCollectionId)
    {
        $this->availableResources = new Collection;
        $this->selectedResources = new Collection;
        if ($resourceCollectionId != null) {
            $resourcesInCollection = ResourceCollection::find($resourceCollectionId)->resources()->get();
            $this->availableResources = Resource::whereNotIn('id', $resourcesInCollection->pluck('id'))->get();
            $this->selectedResources = $resourcesInCollection;
        } else {
            $this->availableResources = Resource::orderBy('title')->get();
        }
    }

    public function addResource(int $id): void
    {
        /** @var ?Resource $resourceToAdd */
        $resourceToAdd = $this->availableResources->find($id);
        if ($resourceToAdd) {
            $this->selectedResources->push($resourceToAdd);
            $this->availableResources = $this->availableResources->except([$id]);
            $this->message = __('Resource ":resource" added to collection.', ['resource' => $resourceToAdd->getTranslation('title', locale())]);
        }
    }

    public function removeResource(int $id): void
    {
        /** @var ?Resource $resourceToRemove */
        $resourceToRemove = $this->selectedResources->find($id);
        if ($resourceToRemove) {
            $this->availableResources->push($resourceToRemove);
            $this->selectedResources = $this->selectedResources->except([$id]);
            $this->message = __('Resource ":resource" removed from collection.', ['resource' => $resourceToRemove->getTranslation('title', locale())]);
        }
    }

    public function render()
    {
        return view('livewire.resource-select');
    }
}
