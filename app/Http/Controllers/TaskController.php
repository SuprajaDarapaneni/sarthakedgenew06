<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Throwable;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        \Log::info('TaskController store request data:', $request->all());
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:191',
            'priority' => 'nullable|in:low,medium,high',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()], 400);
        }

        try {
            $data = $request->all();
            $data['school_id'] = Auth::user()->school_id;
            $data['status'] = 0; // Default pending

            $task = Task::create($data);
            \Log::info('Task created successfully with ID: ' . $task->id);
            return response()->json(['error' => false, 'message' => 'Task created successfully']);
        } catch (Throwable $e) {
            \Log::error('Task creation failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => true, 'message' => 'Internal Server Error'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $task = Task::owner()->findOrFail($id);
            
            if ($request->has('status')) {
                // Toggle status or update boolean
                $task->status = $request->status;
            } else {
                // Update editable fields
                $task->title = $request->title ?? $task->title;
                $task->priority = $request->priority ?? $task->priority;
                $task->description = $request->description ?? $task->description;
            }
            
            $task->save();
            return response()->json(['error' => false, 'message' => 'Task updated successfully']);
        } catch (Throwable $e) {
            \Log::error('Task update failed: ' . $e->getMessage());
            return response()->json(['error' => true, 'message' => 'Internal Server Error'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $task = Task::owner()->findOrFail($id);
            $task->delete();
            ResponseService::successResponse('Task deleted successfully');
        } catch (Throwable $e) {
            ResponseService::logErrorResponse($e);
            ResponseService::errorResponse();
        }
    }
}
