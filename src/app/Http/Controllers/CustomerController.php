<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Customer\CreateCustomerRequest;
use App\Http\Requests\Customer\ListCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use Illuminate\Http\JsonResponse;
use App\Services\CustomerService;

class CustomerController extends Controller
{

    /**
     * Constructor to instantiate Request
     * @param CustomerService $customerService
     */
    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * Create a Customer
     * @param CreateCustomerRequest $createCustomerRequest
     * @return JsonResponse
     */
    public function create(CreateCustomerRequest $createCustomerRequest) : JsonResponse
    {
        $params = $createCustomerRequest->all();

        $customerCreated = $this->customerService->create($params);

        return response()->json($customerCreated);
    }

    /**
     * Read Customer(s)
     * @param ListCustomerRequest $listCustomerRequest
     * @return JsonResponse
     */
    public function read(ListCustomerRequest $listCustomerRequest) : JsonResponse
    {
        $params = $listCustomerRequest->all();

        $customers = $this->customerService->read($params);

        return response()->json($customers);
    }

    /**
     * Update a Customer
     * @param UpdateCustomerRequest $updateCustomerRequest
     * @param int $customerID
     * @return JsonResponse
     */
    public function update(UpdateCustomerRequest $updateCustomerRequest, int $customerID) : JsonResponse
    {
        $params = $updateCustomerRequest->all();

        $customerUpdated = $this->customerService->update($params, $customerID);

        return response()->json($customerUpdated);
    }

    /**
     * Delete a Customer
     * @param int $customerID
     * @return JsonResponse
     */
    public function delete(int $customerID) : JsonResponse
    {
        $customerDeleted = $this->customerService->delete($customerID);

        return response()->json($customerDeleted);
    }
}
