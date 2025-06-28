<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Deliverable;
use App\Http\Resources\DeliverableResource;
use App\Http\Requests\StoreDeliverableRequest;
use App\Http\Requests\UpdateDeliverableRequest;

class DeliverableController extends BaseController
{
    protected $model = Deliverable::class;
    protected $resource = DeliverableResource::class;
    protected $collectionResource = DeliverableResource::class;
    protected $rules = [
        'project_id' => 'required|exists:projects,id',
        'file_id' => 'required|exists:project_files,id',
        'delivered_to' => 'required|exists:client_employees,id',
        'delivery_method' => 'required|in:email,platform,whatsapp,ftp,other',
    ];

    public function index(Request $request)
    {
        $deliverables = Deliverable::query()
            ->when($request->project_id, fn($q, $projectId) => $q->where('project_id', $projectId))
            ->with(['project', 'file', 'recipient', 'deliverer'])
            ->paginate(10);

        return ($this->collectionResource)::collection($deliverables);
    }

    public function store(StoreDeliverableRequest $request)
    {
        $deliverable = Deliverable::create([
            ...$request->validated(),
            'delivered_by' => auth()->id(),
            'delivery_date' => now(),
        ]);

        return new $this->resource($deliverable);
    }

    public function show(Deliverable $deliverable)
    {
        return new $this->resource($deliverable->load([
            'project',
            'file',
            'recipient',
            'deliverer'
        ]));
    }

    public function update(UpdateDeliverableRequest $request, Deliverable $deliverable)
    {
        $deliverable->update($request->validated());
        return new $this->resource($deliverable);
    }

    public function destroy(Deliverable $deliverable)
    {
        $deliverable->delete();
        return response()->json(['message' => 'Deliverable deleted successfully']);
    }
}
