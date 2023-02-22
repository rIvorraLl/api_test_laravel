<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommunityRequest;
use App\Http\Requests\UpdateCommunityRequest;
use App\Models\Community;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function index(Request $request)
    {
        $communities = Community::where('name', 'ilike', "%$request->name%")
        ->limit(1)
            ->get();

        return view('communities.results', [
            'communities' => $communities,
        ]);
    }

    /**
     * Summary of create
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('communities.create');
    }

    /**
     * Summary of store
     *
     * @param  StoreCommunityRequest  $request
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function store(StoreCommunityRequest $request)
    {
        $validated = $request->validated();
        $request->user()->communities()->create($validated);

        return redirect(route('posts.index'))->with('message', '¡Nueva comunidad creada!');
    }

    /**
     * Summary of show
     *
     * @param  mixed  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Community $community)
    {
        return view('communities.index', [
            'communities' => $community,
        ]);
    }

    public function edit(Community $community)
    {
        //
    }

    public function update(UpdateCommunityRequest $request, Community $community)
    {
        //
    }

    public function destroy(Community $community)
    {
        //
    }
}
