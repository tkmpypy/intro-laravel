<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteRequest;
use App\Http\Requests\DoneRequest;
use App\Http\Requests\StoreTodoRequest;
use App\Models\Todo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class TodoController extends Controller
{
    public function show(): View
    {
        try {
            $items = Todo::query()->where('deleted_at', null)->orderBy('created_at', 'desc')->simplePaginate(15);
            Log::info($items);
        } catch (\Throwable $th) {
            Log::error($th);
        }

        return view('todo', [
            'items' => $items,
        ]);
    }

    public function store(StoreTodoRequest $request): RedirectResponse
    {
        try {
            $input = $request->validated();
            Log::info($input);

            Todo::query()->create(['value' => $input['value']]);
        } catch (\Throwable $th) {
            Log::error($th);
        }

        return redirect('/');
    }

    public function done(DoneRequest $request): RedirectResponse
    {
        try {
            $input = $request->validated();
            Log::info($input);

            Todo::query()->where('id', $input['id'])->update(['done' => $input['done']]);
        } catch (\Throwable $th) {
            Log::error($th);
        }

        return redirect('/');
    }

    public function delete(DeleteRequest $request): RedirectResponse
    {
        try {
            $input = $request->validated();
            Log::info($input);

            Todo::query()->where('id', $input['id'])->delete();
        } catch (\Throwable $th) {
            Log::error($th);
        }

        return redirect('/');
    }
}
