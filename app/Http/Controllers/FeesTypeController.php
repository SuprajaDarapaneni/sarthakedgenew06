<?php

namespace App\Http\Controllers;

use App\Repositories\FeesType\FeesTypeInterface;
use App\Services\BootstrapTableService;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class FeesTypeController extends Controller
{
    private FeesTypeInterface $feesType;

    public function __construct(FeesTypeInterface $feesType)
    {
        $this->feesType = $feesType;
    }

    public function index()
    {
        ResponseService::noFeatureThenRedirect('Fees Management');
        ResponseService::noPermissionThenRedirect('fees-type-list');
        return view('fees.fees_types');
    }

    public function store(Request $request)
    {
        ResponseService::noFeatureThenSendJson('Fees Management');
        ResponseService::noPermissionThenSendJson('fees-type-create');
        try {
            DB::beginTransaction();

            // Create main fee type (parent)
            $feesType = $this->feesType->create([
                'name' => $request->name,
                'description' => $request->description,
                'parent_id' => null,
            ]);

            // Create child components if any
            if ($request->filled('components') && is_array($request->components)) {
                foreach ($request->components as $component) {
                    if (!empty($component['name'])) {
                        $this->feesType->create([
                            'name' => $component['name'],
                            'description' => $component['description'] ?? null,
                            'parent_id' => $feesType->id,
                        ]);
                    }
                }
            }

            DB::commit();
            ResponseService::successResponse('Data Stored Successfully');
        } catch (Throwable $e) {
            DB::rollback();
            ResponseService::logErrorResponse($e, "FeesTypeController -> store method");
            ResponseService::errorResponse();
        }
    }

    public function show()
    {
        ResponseService::noFeatureThenRedirect('Fees Management');
        ResponseService::noPermissionThenRedirect('fees-type-list');
        $offset = request('offset', 0);
        $limit = request('limit', 10);
        $sort = request('sort', 'id');
        $order = request('order', 'DESC');
        $search = request('search');
        $showDeleted = request('show_deleted');

        // Only show root-level fee types (parent_id IS NULL)
        $sql = $this->feesType->builder()
            ->whereNull('parent_id')
            ->withCount('components')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('id', 'LIKE', "%$search%")
                        ->orwhere('name', 'LIKE', "%$search%")
                        ->orwhere('description', 'LIKE', "%$search%");
                });
            })
            ->when(!empty($showDeleted), function ($query) {
                $query->onlyTrashed();
            });

        $total = $sql->count();
        if ($offset >= $total && $total > 0) {
            $lastPage = floor(($total - 1) / $limit) * $limit;
            $offset = $lastPage;
        }
        $sql->orderBy($sort, $order)->skip($offset)->take($limit);
        $res = $sql->get();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $no = 1;
        foreach ($res as $row) {
            if ($showDeleted) {
                $operate = BootstrapTableService::restoreButton(route('fees-type.restore', $row->id));
                $operate .= BootstrapTableService::trashButton(route('fees-type.trash', $row->id));
            } else {
                $operate = BootstrapTableService::editButton(route('fees-type.update', $row->id));
                $operate .= BootstrapTableService::deleteButton(route('fees-type.destroy', $row->id));
            }
            $tempRow = $row->toArray();
            $tempRow['no'] = $no++;
            $tempRow['components_count'] = $row->components_count;
            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }

    public function update(Request $request, $id)
    {
        ResponseService::noFeatureThenSendJson('Fees Management');
        ResponseService::noPermissionThenSendJson('fees-type-edit');
        try {
            $this->feesType->update($id, [
                'name' => $request->edit_name,
                'description' => $request->edit_description,
            ]);
            ResponseService::successResponse("Data Updated Successfully");
        } catch (Throwable $e) {
            ResponseService::logErrorResponse($e, "FeesTypeController -> Update method");
            ResponseService::errorResponse();
        }
    }

    public function destroy($id)
    {
        ResponseService::noFeatureThenSendJson('Fees Management');
        ResponseService::noPermissionThenSendJson('fees-type-delete');
        try {
            $this->feesType->deleteById($id);
            ResponseService::successResponse('Data Deleted Successfully');
        } catch (Throwable $e) {
            ResponseService::logErrorResponse($e, "FeesTypeController -> destroy method");
            ResponseService::errorResponse();
        }
    }

    public function restore(int $id)
    {
        ResponseService::noFeatureThenRedirect('Fees Management');
        ResponseService::noAnyPermissionThenRedirect(['fees-type-delete']);
        try {
            $this->feesType->findOnlyTrashedById($id)->restore();
            ResponseService::successResponse("Data Restored Successfully");
        } catch (Throwable $e) {
            ResponseService::logErrorResponse($e, "FeesTypeController -> restore method");
            ResponseService::errorResponse();
        }
    }

    public function trash($id)
    {
        ResponseService::noFeatureThenRedirect('Fees Management');
        ResponseService::noPermissionThenSendJson('fees-type-delete');
        try {
            $this->feesType->findOnlyTrashedById($id)->forceDelete();
            ResponseService::successResponse("Data Deleted Permanently");
        } catch (Throwable $e) {
            ResponseService::logErrorResponse($e, "FeesTypeController -> trash method");
            ResponseService::errorResponse();
        }
    }
}
