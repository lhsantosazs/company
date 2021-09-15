<?php

namespace App\Services;

use App\Models\Company;

class CompanyService
{
    const DELETED = 'Empresa deletada com sucesso';
    const DUPLICATED = 'Empresa duplicada';
    const FAIL = 'Falha ao salvar empresa';
    const NOT_FOUND = 'Empresa inexistente';
    const SAVED = 'Empresa salva com sucesso';

    /**
     * Create a Company
     * @param array $params
     * @return array
     */
    public function create(array $params) : array
    {
        //Check duplicates
        $exists = $this->getCompanyByCnpj($params['cnpj']);
        if (!empty($exists)) {
            return ['msg' => self::DUPLICATED];
        }

        $company = new Company();
        $company->name = $params['name'];
        $company->cnpj = $params['cnpj'];
        $company->adress = $params['adress'];

        return $this->save($company);
    }

    /**
     * Read Company(s)
     * @param array $params
     * @return array
     */
    public function read(array $params) : array
    {
        $id = isset($params['id']) ? $params['id'] : null;

        return $this->getCompanyByIdWithCustomerAndEmployees($id);
    }

    /**
     * Update a Company
     * @param array $params
     * @param int $companyID
     * @return array
     */
    public function update(array $params, int $companyID) : array
    {
        $company = $this->getCompanyById($companyID);
        if (empty($company)) {
            return ['msg' => self::NOT_FOUND];
        }

        $company->name = isset($params['name']) ? $params['name'] : $company->name;
        $company->cnpj = isset($params['cnpj']) ? $params['cnpj'] : $company->cnpj;
        $company->adress = isset($params['adress']) ? $params['adress'] : $company->adress;

        return $this->save($company);
    }

    /**
     * Update a Company
     * @param array $params
     * @param int $companyID
     * @return array
     */
    public function delete(int $companyID) : array
    {
        $company = $this->getCompanyById($companyID);
        if (empty($company)) {
            return ['msg' => self::NOT_FOUND];
        }

        $company->delete();
        return ['msg' => self::DELETED];
    }

    /**
     * Save Company data in database
     * @param Company $company
     * @return Array
    */
    protected function save(Company $company) : array
    {
        $saved = $company->save();

        return [
            'msg' => $saved ? self::SAVED : self::FAIL,
            'Company' => $company
        ];
    }

    /**
     * Get Company cnpj
     * @param string $cnpj
     * @return Company|null
     */
    protected function getCompanyByCnpj(string $cnpj)
    {
        return Company::filterByCnpj($cnpj)->first();
    }

    /**
     * Get Company by id
     * @param ?int $id
     * @return Company|null
     */
    protected function getCompanyById(?int $id)
    {
        return Company::filterById($id)->first();
    }

    /**
     * Get Company by id with all
     * @param ?int $id
     * @return Company|null
     */
    protected function getCompanyByIdWithCustomerAndEmployees(?int $id)
    {
        return Company::filterById($id)
                      ->with(
                        'customers:id,name,email',
                        'employees:id,name,email'
                      )
                      ->get()
                      ->toArray();
    }
}
