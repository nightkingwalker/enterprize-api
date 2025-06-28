<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Http\Resources\ClientResource;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;

class ClientController extends BaseController
{
    protected $model = Client::class;
    protected $resource = ClientResource::class;
    protected $collectionResource = ClientResource::class;
    protected $rules = [
        'user_id' => 'nullable|exists:users,id',
        'company_name' => 'required|string|max:255',
        'contact_person' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
    ];

    public function index(Request $request)
    {
        $clients = Client::query()
            ->when($request->search, fn($q, $search) => $q->where('company_name', 'like', "%{$search}%"))
            ->paginate(10);

        return ($this->collectionResource)::collection($clients);
    }

    public function store(StoreClientRequest $request)
    {
        $client = Client::create($request->validated());
        return new $this->resource($client);
    }

    public function show(Client $client)
    {
        return new $this->resource($client->load(['domains', 'employees']));
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $client->update($request->validated());
        return new $this->resource($client);
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return response()->json(['message' => 'Client deleted successfully']);
    }
}
