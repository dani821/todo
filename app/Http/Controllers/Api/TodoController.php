<?php

namespace App\Http\Controllers\Api;

use App\Models\Todo;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(
            Todo::all()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoRequest $request): JsonResponse
    {
        $todo = Todo::query()->create($request->validated());
        return response()->json($todo->refresh(), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo): Todo
    {
        return $todo;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTodoRequest $request, Todo $todo): JsonResponse
    {
        $todo->update($request->validated());
        return response()->json($todo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo): JsonResponse
    {
        $todo->delete();
        return response()->json(null, 204);
    }
}
