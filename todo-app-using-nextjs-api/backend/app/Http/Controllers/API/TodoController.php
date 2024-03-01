<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TodoStoreRequest;
use App\Http\Requests\TodoUpdateRequest;
use App\Http\Resources\TodoCollection;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): TodoCollection
    {
        try {
            return new TodoCollection(Todo::query()->where('deleted_at', null)->get());
        } catch (\Throwable $th) {
            Log::error('Could not get task list', $th);
            throw $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TodoStoreRequest $request): JsonResponse
    {
        try {
            $input = $request->validated();
            Log::info($input);

            $m = Todo::query()->create(['value' => $input['value']]);

            return (new TodoResource($m))->response()->setStatusCode(201);
        } catch (\Throwable $th) {
            Log::error($th);
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): void
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TodoUpdateRequest $request, string $id): JsonResponse
    {
        try {
            $input = $request->validated();
            Log::info(sprintf('update task: %s', $id));
            Log::info($input);

            $q = [];
            if (isset($input['value'])) {
                $q['value'] = $input['value'];
            }
            if (isset($input['done'])) {
                $q['done'] = $input['done'];
            }

            Log::info($q);
            Todo::query()->where('id', $id)->update($q);

            return (new TodoResource(Todo::query()->where('id', $id)->first()))->response()->setStatusCode(200);
        } catch (\Throwable $th) {
            Log::error($th);
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        Log::info(sprintf('delete task: %s', $id));
        try {
            Todo::query()->where('id', $id)->delete();

            return response()->noContent();
        } catch (\Throwable $th) {
            Log::error('Could not delete task', $th);
            throw $th;
        }
    }
}
