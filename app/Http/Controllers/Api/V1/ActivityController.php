<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityFilterRequest;
use App\Http\Requests\ActivityUpdateRequest;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use App\Services\ActivityService;
use Illuminate\Support\Facades\Storage;

use function App\Utilities\deleteImage;
use function App\Utilities\imageSaver;
use function App\Utilities\json;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ActivityFilterRequest $request , ActivityService $activityService)
    {
        $validated = $request->validated();
        $activities = $activityService->search($validated);

        return json(ActivityResource::collection($activities));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreActivityRequest $request)
    {
        $validated = $request->validated();

        if($request->hasFile('image')){
            $file = $request->file('image');
            $validated['image'] = imageSaver($file, $request->name);
        }

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

        if($request->hasFile('image')){
             if ($activity->image && Storage::disk('public')->exists($activity->image)) {
                deleteImage($activity->image);
        }
            $file = $request->file('image');
            $validated['image'] = imageSaver($file, $request->name);
        }

        $activity->update($validated);

        return json($activity,'activity updated',200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
            if ($activity->image && Storage::disk('public')->exists($activity->image)) {
            deleteImage($activity->image);
        }

        $activity->delete();

        return json([],'deleted successfully',200);
    }
}
