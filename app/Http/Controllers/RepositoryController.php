<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRepositoryRequest;
use App\Http\Requests\StorRepositoryRequest;
use App\Models\Repository;
use Illuminate\Http\Request;

class RepositoryController extends Controller
{

    public function index(Request $request)
    {
        return view('repositories.index', [
            'repositories' => $request->user()->repositories,
        ]);
    }

    public function create()
    {
        $this->authorize('create', Repository::class);
        return view('repositories.create');
    }

    public function show(Request $request, Repository $repository)
    {
        $this->authorize('view', $repository);
        return view('repositories.show',compact('repository') );
    }

    public function edit(Request $request, Repository $repository)
    {
        $this->authorize('view', $repository);
        return view('repositories.edit',compact('repository') );
    }



    public function store(StorRepositoryRequest $request)
    {

        $request->user()->repositories()->create($request->all());
        return redirect()->route('repositories.index');
    }

    public function update(StoreRepositoryRequest $request, Repository $repository)
    {
        /*if ($request->user()->id !== $repository->user_id) {
            abort(403);
        }*/
        $this->authorize('update', $repository);
        $repository->update($request->all());
        return redirect()->route('repositories.show', $repository);
    }

    public function destroy(Repository $repository)
    {
        $this->authorize('delete', $repository);
        $repository->delete();
        return redirect()->route('repositories.index');
    }


}
