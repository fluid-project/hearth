<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateResourceCollectionRequest;
use App\Http\Requests\DestroyResourceCollectionRequest;
use App\Http\Requests\UpdateResourceCollectionRequest;
use App\Models\ResourceCollection;

class ResourceCollectionController extends Controller
{
    /**
     * Display a listing of the resource collection.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('resource-collections.index', ['resourceCollections' => ResourceCollection::orderBy('title')->get()]);
    }

    /**
     * Show the form for creating a new resource collection.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', ResourceCollection::class);

        return view('resource-collections.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateResourceCollectionRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateResourceCollectionRequest $request)
    {
        $resourceCollection = ResourceCollection::create($request->validated());

        flash(__('resource-collection.create_succeeded'), 'success');

        return redirect(\localized_route('resource-collections.show', ['resourceCollection' => $resourceCollection]));
    }

    /**
     * Display the specified resource collection.
     *
     * @param  \App\Models\ResourceCollection  $resourceCollection
     * @return \Illuminate\View\View
     */
    public function show(ResourceCollection $resourceCollection)
    {
        return view('resource-collections.show', ['resourceCollection' => $resourceCollection]);
    }

    /**
     * Show the form for editing the specified resource collection.
     *
     * @param  \App\Models\ResourceCollection  $resourceCollection
     * @return \Illuminate\View\View
     */
    public function edit(ResourceCollection $resourceCollection)
    {
        return view('resource-collections.edit', ['resourceCollection' => $resourceCollection]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateResourceCollectionRequest  $request
     * @param  \App\Models\ResourceCollection  $resourceCollection
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateResourceCollectionRequest $request, ResourceCollection $resourceCollection)
    {
        $resourceCollection->fill($request->validated());
        $resourceCollection->save();

        flash(__('resource-collection.update_succeeded'), 'success');

        return redirect(\localized_route('resource-collections.show', $resourceCollection));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\DestroyResourceCollectionRequest  $request
     * @param  \App\Models\ResourceCollection  $resourceCollection
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DestroyResourceCollectionRequest $request, ResourceCollection $resourceCollection)
    {
        $resourceCollection->delete();

        flash(__('resource-collection.destroy_succeeded'), 'success');

        return redirect(\localized_route('dashboard'));
    }
}
