<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommunityCollection;
use App\Http\Resources\CommunityResource;
use App\Models\Community;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function index()
    {
        return CommunityCollection::make(Community::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required | string',
            'description' => 'required | string',
            'rules' => 'required | string',
        ]);

        $community = Community::create($validated);

        return CommunityResource::make($community);
    }

   /**
    * 
    */
    public function show(Community $community)
    {
        return CommunityResource::make($community);
    }

    public function update(Request $request, Community $community)
    {
        $validated = $request->validate([
            'name' => 'string',
            'description' => 'string',
            'rules' => 'string',
        ]);
        $community->update($validated);

        return CommunityResource::make($community);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Community $community)
    {
        $community->delete();
        return response()->noContent();
    }
}
