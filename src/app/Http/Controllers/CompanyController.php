<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Company\CreateCompanyRequest;
use App\Http\Requests\Company\ListCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use Illuminate\Http\JsonResponse;
use App\Services\CompanyService;

class CompanyController extends Controller
{

    /**
     * Constructor to instantiate Request
     * @param CompanyService $companyService
     */
    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    /**
     * Create a Company
     * @param CreateCompanyRequest $createCompanyRequest
     * @return JsonResponse
     */
    public function create(CreateCompanyRequest $createCompanyRequest) : JsonResponse
    {
        $params = $createCompanyRequest->all();

        $companyCreated = $this->companyService->create($params);

        return response()->json($companyCreated);
    }

    /**
     * Read Company(s)
     * @param ListCompanyRequest $listCompanyRequest
     * @return JsonResponse
     */
    public function read(ListCompanyRequest $listCompanyRequest) : JsonResponse
    {
        $params = $listCompanyRequest->all();

        $companys = $this->companyService->read($params);

        return response()->json($companys);
    }

    /**
     * Update a Company
     * @param UpdateCompanyRequest $updateCompanyRequest
     * @param int $companyID
     * @return JsonResponse
     */
    public function update(UpdateCompanyRequest $updateCompanyRequest, int $companyID) : JsonResponse
    {
        $params = $updateCompanyRequest->all();

        $companyUpdated = $this->companyService->update($params, $companyID);

        return response()->json($companyUpdated);
    }

    /**
     * Delete a Company
     * @param int $companyID
     * @return JsonResponse
     */
    public function delete(int $companyID) : JsonResponse
    {
        $companyDeleted = $this->companyService->delete($companyID);

        return response()->json($companyDeleted);
    }
}
