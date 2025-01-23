<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Get a list of tasks.
     *
     * Returns a list of all tasks.
     * You can filter tasks by completion status.
     *
     * @queryParam status boolean Filter by completion status. Example: true
     *
     * @response 200 [
     *   {
     *     "id": 1,
     *     "name": "Test Task",
     *     "description": "This is a test task.",
     *     "is_completed": false,
     *     "created_at": "2025-01-23T17:28:10.000000Z",
     *     "updated_at": "2025-01-23T17:28:10.000000Z"
     *   }
     * ]
     */

    public function index(Request $request)
    {
        $tasks = Task::query();

        if ($request->has('status')) {
            $tasks->where('is_completed', $request->status);
        }
        return response()->json($tasks->get());
    }

    /**
     * Create a new task.
     *
     * Creates a new task in the system.
     *
     * @bodyParam name string required The name of the task. Example: Test Task
     * @bodyParam description string required A description of the task. Example: This is a test task.
     *
     * @response 201 {
     *   "id": 1,
     *   "name": "Test Task",
     *   "description": "This is a test task.",
     *   "is_completed": false,
     *   "created_at": "2025-01-23T17:28:10.000000Z",
     *   "updated_at": "2025-01-23T17:28:10.000000Z"
     * }
     */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'description' => 'required|max:255',
        ]);
        $task = Task::create($validated);
        return response()->json($task, 201);
    }

    /**
     * Update an existing task.
     *
     * Updates the specified task's details.
     *
     * @bodyParam name string The name of the task. Example: Updated Task Name
     * @bodyParam description string The description of the task. Example: Updated Task Description
     * @bodyParam is_completed boolean The completion status of the task. Example: true
     *
     * @response 200 {
     *   "id": 1,
     *   "name": "Updated Task Name",
     *   "description": "Updated Task Description",
     *   "is_completed": true,
     *   "created_at": "2025-01-23T17:28:10.000000Z",
     *   "updated_at": "2025-01-23T17:35:10.000000Z"
     * }
     */

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'name' => 'sometimes|max:100',
            'description' => 'sometimes|max:255',
            'is_completed' => 'sometimes|boolean',
        ]);

        $task->update($validated);

        return response()->json($task);
    }

    /**
     * Delete a task.
     *
     * Deletes the specified task from the system.
     *
     * @response 204 {
     * }
     */

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json(null, 204);
    }

    /**
     * Toggle task completion status.
     *
     * Switches the task's completion status between completed and not completed.
     *
     * @response 200 {
     *   "id": 1,
     *   "name": "Test Task",
     *   "description": "This is a test task.",
     *   "is_completed": true,
     *   "created_at": "2025-01-23T17:28:10.000000Z",
     *   "updated_at": "2025-01-23T17:40:10.000000Z"
     * }
     */

    public function toggleCompletion(Task $task)
    {
        $task->is_completed = !$task->is_completed;
        $task->save();

        return response()->json($task);
    }

}
