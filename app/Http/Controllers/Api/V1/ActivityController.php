<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityUpdateRequest;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use Illuminate\Http\Request;

use function App\Utilities\json;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $activities = Activity::all();
        return json([ ActivityResource::collection($activities)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreActivityRequest $request)
    {
        $validated = $request->validated();

        $activity = Activity::create($validated);

        return json($activity,'activity created',201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        return json(new ActivityResource($activity));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ActivityUpdateRequest $request, Activity $activity)
    {
        $validated = $request->validated();

        $activity->update($validated);

        return json($activity,'activity updated',200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        $activity->delete();

        return json([],'deleted successfully',200);
    }
}
