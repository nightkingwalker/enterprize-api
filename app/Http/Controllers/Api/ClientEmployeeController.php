<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ClientEmployee;
use App\Http\Resources\ClientEmployeeResource;
use App\Http\Requests\StoreClientEmployeeRequest;
use App\Http\Requests\UpdateClientEmployeeRequest;

class ClientEmployeeController extends BaseController
{
    protected $model = ClientEmployee::class;
    protected $resource = ClientEmployeeResource::class;
    protected $collectionResource = ClientEmployeeResource::class;
    protected $rules = [
        'client_id' => 'required|exists:clients,id',
        'user_id' => 'nullable|exists:users,id',
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:client_employees,email',
    ];

    public function index(Request $request)
    {
        $employees = ClientEmployee::query()
            ->when($request->client_id, fn($q, $clientId) => $q->where('client_id', $clientId))
            ->paginate(10);

        return ($this->collectionResource)::collection($employees);
    }

    public function store(StoreClientEmployeeRequest $request)
    {
        $employee = ClientEmployee::create($request->validated());
        return new $this->resource($employee);
    }

    public function show(ClientEmployee $employee)
    {
        return new $this->resource($employee->load(['emailAliases']));
    }

    public function update(UpdateClientEmployeeRequest $request, ClientEmployee $employee)
    {
        $employee->update($request->validated());
        return new $this->resource($employee);
    }

    public function destroy(ClientEmployee $employee)
    {
        $employee->delete();
        return response()->json(['message' => 'Employee deleted successfully']);
    }
}
