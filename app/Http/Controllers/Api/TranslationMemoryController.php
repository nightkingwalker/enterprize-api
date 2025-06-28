<?php

namespace App\Http\Controllers\Api;

use App\Models\TranslationMemory;
use App\Http\Resources\TranslationMemoryResource;
use App\Http\Requests\StoreTranslationMemoryRequest;
use App\Http\Requests\UpdateTranslationMemoryRequest;

class TranslationMemoryController extends BaseController
{
    protected $model = TranslationMemory::class;
    protected $resource = TranslationMemoryResource::class;
    protected $collectionResource = TranslationMemoryResource::class;
    protected $rules = [
        'source_text' => 'required|string',
        'target_text' => 'required|string',
        'source_language' => 'required|string|size:2',
        'target_language' => 'required|string|size:2',
    ];

    public function index(Request $request)
    {
        $memories = TranslationMemory::query()
            ->when($request->source_language, fn($q, $lang) => $q->where('source_language', $lang))
            ->when($request->target_language, fn($q, $lang) => $q->where('target_language', $lang))
            ->when($request->search, function ($q, $search) {
                return $q->where('source_text', 'like', "%{$search}%")
                    ->orWhere('target_text', 'like', "%{$search}%");
            })
            ->paginate(20);

        return ($this->collectionResource)::collection($memories);
    }

    public function store(StoreTranslationMemoryRequest $request)
    {
        $memory = TranslationMemory::create($request->validated());
        return new $this->resource($memory);
    }

    public function show(TranslationMemory $memory)
    {
        return new $this->resource($memory);
    }

    public function update(UpdateTranslationMemoryRequest $request, TranslationMemory $memory)
    {
        $memory->update($request->validated());
        return new $this->resource($memory);
    }

    public function destroy(TranslationMemory $memory)
    {
        $memory->delete();
        return response()->json(['message' => 'Translation memory deleted successfully']);
    }
}
