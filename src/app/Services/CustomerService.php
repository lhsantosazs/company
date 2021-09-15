<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\CompanyCustomer;

class CustomerService
{
    const DELETED = 'Cliente deletado com sucesso';
    const DUPLICATED = 'Cliente duplicado';
    const FAIL = 'Falha ao salvar cliente';
    const NOT_FOUND = 'Cliente inexistente';
    const SAVED = 'Cliente salvo com sucesso';
    const INVALID_EXT = 'Enviei o documento em pdf ou jpg)';
    const DOC_EXT = ['pdf', 'jpg'];

    /**
     * Create a Customer
     * @param array $params
     * @return array
     */
    public function create(array $params) : array
    {
        try {
            $ext = $params['doc']->extension();

            if (!in_array($ext, self::DOC_EXT)) {
                return ['msg' => self::INVALID_EXT];
            }
        } catch (\Throwable $e) {
            return ['msg' => self::INVALID_EXT];
        }

        //Check duplicates
        $exists = $this->getCustomerByCpf($params['cpf']);
        if (!empty($exists)) {
            return ['msg' => self::DUPLICATED];
        }

        $Customer = new Customer();
        $Customer->login = $params['login'];
        $Customer->name = $params['name'];
        $Customer->cpf = $params['cpf'];
        $Customer->email = $params['email'];
        $Customer->adress = $params['adress'];
        $Customer->password = $params['password'];
        $Customer->doc = utf8_encode($params['doc']->get());
        $CustomerSaved = $Customer->save();

        if ($CustomerSaved) {
            $companyCustomer = new CompanyCustomer();
            $companyCustomer->company_id = $params['companyId'];
            $companyCustomer->Customer_id = $Customer->id;
            $CustomerSaved = $companyCustomer->save();
        }

        return [
            'msg' => $CustomerSaved ? self::SAVED : self::FAIL,
            'Customer' => $Customer
        ];
    }

    /**
     * Read Customer(s)
     * @param array $params
     * @return array
     */
    public function read(array $params) : array
    {
        $id = isset($params['id']) ? $params['id'] : null;

        return $this->getCustomerByIdWithCompany($id);
    }

    /**
     * Update a Customer
     * @param array $params
     * @param int $CustomerID
     * @return array
     */
    public function update(array $params, int $CustomerID) : array
    {
        $Customer = $this->getCustomerById($CustomerID);
        if (empty($Customer)) {
            return ['msg' => self::NOT_FOUND];
        }

        $Customer->login = isset($params['login']) ? $params['login'] : $Customer->login;
        $Customer->name = isset($params['name']) ? $params['name'] : $Customer->name;
        $Customer->cpf = isset($params['cpf']) ? $params['cpf'] : $Customer->cpf;
        $Customer->email = isset($params['email']) ? $params['email'] : $Customer->email;
        $Customer->adress = isset($params['adress']) ? $params['adress'] : $Customer->adress;
        $Customer->password = isset($params['password']) ? $params['password'] : $Customer->password;
        $Customer->doc = isset($params['doc']) ? utf8_encode($params['doc']->get()) : $Customer->doc;

        return [
            'msg' => $Customer->save() ? self::SAVED : self::FAIL,
            'Customer' => $Customer
        ];
    }

    /**
     * Update a Customer
     * @param array $params
     * @param int $CustomerID
     * @return array
     */
    public function delete(int $CustomerID) : array
    {
        $Customer = $this->getCustomerById($CustomerID);
        if (empty($Customer)) {
            return ['msg' => self::NOT_FOUND];
        }

        $Customer->delete();
        return ['msg' => self::DELETED];
    }

    /**
     * Get Customer cpf
     * @param string $cpf
     * @return Customer|null
     */
    protected function getCustomerByCpf(string $cpf)
    {
        return Customer::filterByCpf($cpf)->first();
    }

    /**
     * Get Customer by id
     * @param ?int $id
     * @return Customer|null
     */
    protected function getCustomerById(?int $id)
    {
        return Customer::filterById($id)->first();
    }

    /**
     * Get Customer by id with all
     * @param ?int $id
     * @return Customer|null
     */
    protected function getCustomerByIdWithCompany(?int $id)
    {
        return Customer::filterById($id)
                       ->with('company:id,name,adress')
                       ->get()
                       ->toArray();
    }
}
