<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Employee\CreateEmployeeRequest;
use App\Http\Requests\Employee\ListEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use Illuminate\Http\JsonResponse;
use App\Services\EmployeeService;

class EmployeeController extends Controller
{

    /**
     * Constructor to instantiate Request
     * @param EmployeeService $employeeService
     */
    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    /**
     * Create a Employee
     * @param CreateEmployeeRequest $createEmployeeRequest
     * @return JsonResponse
     */
    public function create(CreateEmployeeRequest $createEmployeeRequest) : JsonResponse
    {
        $params = $createEmployeeRequest->all();

        $employeeCreated = $this->employeeService->create($params);

        return response()->json($employeeCreated);
    }

    /**
     * Read Employee(s)
     * @param ListEmployeeRequest $listEmployeeRequest
     * @return JsonResponse
     */
    public function read(ListEmployeeRequest $listEmployeeRequest) : JsonResponse
    {
        $params = $listEmployeeRequest->all();

        $employees = $this->employeeService->read($params);

        return response()->json($employees);
    }

    /**
     * Update a Employee
     * @param UpdateEmployeeRequest $updateEmployeeRequest
     * @param int $employeeID
     * @return JsonResponse
     */
    public function update(UpdateEmployeeRequest $updateEmployeeRequest, int $employeeID) : JsonResponse
    {
        $params = $updateEmployeeRequest->all();

        $employeeUpdated = $this->employeeService->update($params, $employeeID);

        return response()->json($employeeUpdated);
    }

    /**
     * Delete a Employee
     * @param int $employeeID
     * @return JsonResponse
     */
    public function delete(int $employeeID) : JsonResponse
    {
        $employeeDeleted = $this->employeeService->delete($employeeID);

        return response()->json($employeeDeleted);
    }
}
