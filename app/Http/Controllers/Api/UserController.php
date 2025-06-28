<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;

class UserController extends BaseController
{
    protected $model = User::class;
    protected $resource = UserResource::class;
    protected $collectionResource = UserResource::class;
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'role' => 'required|in:admin,project_manager,translator,reviewer,client',
    ];

    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->role, fn($q, $role) => $q->where('role', $role))
            ->paginate(10);

        return ($this->collectionResource)::collection($users);
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);
        return new $this->resource($user);
    }

    public function show(User $user)
    {
        return new $this->resource($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $user->update($validated);
        return new $this->resource($user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
