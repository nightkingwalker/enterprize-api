<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Segment;
use App\Http\Resources\SegmentResource;
use App\Http\Requests\StoreSegmentRequest;
use App\Http\Requests\UpdateSegmentRequest;

class SegmentController extends BaseController
{
    protected $model = Segment::class;
    protected $resource = SegmentResource::class;
    protected $collectionResource = SegmentResource::class;
    protected $rules = [
        'task_id' => 'required|exists:tasks,id',
        'original_text' => 'required|string',
        'segment_number' => 'required|integer',
    ];

    public function index(Request $request)
    {
        $segments = Segment::query()
            ->when($request->task_id, fn($q, $taskId) => $q->where('task_id', $taskId))
            ->when($request->status, fn($q, $status) => $q->where('status', $status))
            ->with(['task', 'history', 'comments'])
            ->paginate(50);

        return ($this->collectionResource)::collection($segments);
    }

    public function store(StoreSegmentRequest $request)
    {
        $segment = Segment::create($request->validated());
        return new $this->resource($segment);
    }

    public function show(Segment $segment)
    {
        return new $this->resource($segment->load([
            'task',
            'history.user',
            'comments.user'
        ]));
    }

    public function update(UpdateSegmentRequest $request, Segment $segment)
    {
        $validated = $request->validated();

        // Save to history if text is being updated
        if (isset($validated['translated_text']) && $validated['translated_text'] !== $segment->translated_text) {
            $segment->history()->create([
                'user_id' => auth()->id(),
                'action' => 'edited',
                'content_before' => $segment->translated_text,
                'content_after' => $validated['translated_text'],
            ]);
        }

        $segment->update($validated);
        return new $this->resource($segment);
    }

    public function destroy(Segment $segment)
    {
        $segment->delete();
        return response()->json(['message' => 'Segment deleted successfully']);
    }
}
