<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\CompanyEmployee;

class EmployeeService
{
    const DELETED = 'Funcionario deletado com sucesso';
    const DUPLICATED = 'Funcionario duplicado';
    const FAIL = 'Falha ao salvar funcionario';
    const NOT_FOUND = 'Funcionario inexistente';
    const SAVED = 'Funcionario salvo com sucesso';
    const INVALID_EXT = 'Enviei o documento em pdf ou jpg)';
    const DOC_EXT = ['pdf', 'jpg'];

    /**
     * Create a Employee
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
        $exists = $this->getEmployeeByCpf($params['cpf']);
        if (!empty($exists)) {
            return ['msg' => self::DUPLICATED];
        }

        $employee = new Employee();
        $employee->login = $params['login'];
        $employee->name = $params['name'];
        $employee->cpf = $params['cpf'];
        $employee->email = $params['email'];
        $employee->adress = $params['adress'];
        $employee->password = $params['password'];
        $employee->doc = utf8_encode($params['doc']->get());
        $employeeSaved = $employee->save();

        if ($employeeSaved) {
            $companyEmployee = new CompanyEmployee();
            $companyEmployee->company_id = $params['companyId'];
            $companyEmployee->employee_id = $employee->id;
            $employeeSaved = $companyEmployee->save();
        }

        return [
            'msg' => $employeeSaved ? self::SAVED : self::FAIL,
            'Employee' => $employee
        ];
    }

    /**
     * Read Employee(s)
     * @param array $params
     * @return array
     */
    public function read(array $params) : array
    {
        $id = isset($params['id']) ? $params['id'] : null;

        return $this->getEmployeeByIdWithCompany($id);
    }

    /**
     * Update a Employee
     * @param array $params
     * @param int $employeeID
     * @return array
     */
    public function update(array $params, int $employeeID) : array
    {
        $employee = $this->getEmployeeById($employeeID);
        if (empty($employee)) {
            return ['msg' => self::NOT_FOUND];
        }

        $employee->login = isset($params['login']) ? $params['login'] : $employee->login;
        $employee->name = isset($params['name']) ? $params['name'] : $employee->name;
        $employee->cpf = isset($params['cpf']) ? $params['cpf'] : $employee->cpf;
        $employee->email = isset($params['email']) ? $params['email'] : $employee->email;
        $employee->adress = isset($params['adress']) ? $params['adress'] : $employee->adress;
        $employee->password = isset($params['password']) ? $params['password'] : $employee->password;
        $employee->doc = isset($params['doc']) ? utf8_encode($params['doc']->get()) : $employee->doc;

        return [
            'msg' => $employee->save() ? self::SAVED : self::FAIL,
            'Employee' => $employee
        ];
    }

    /**
     * Update a Employee
     * @param array $params
     * @param int $employeeID
     * @return array
     */
    public function delete(int $employeeID) : array
    {
        $employee = $this->getEmployeeById($employeeID);
        if (empty($employee)) {
            return ['msg' => self::NOT_FOUND];
        }

        $employee->delete();
        return ['msg' => self::DELETED];
    }

    /**
     * Get Employee cpf
     * @param string $cpf
     * @return Employee|null
     */
    protected function getEmployeeByCpf(string $cpf)
    {
        return Employee::filterByCpf($cpf)->first();
    }

    /**
     * Get Employee by id
     * @param ?int $id
     * @return Employee|null
     */
    protected function getEmployeeById(?int $id)
    {
        return Employee::filterById($id)->first();
    }

    /**
     * Get Employee by id with all
     * @param ?int $id
     * @return Employee|null
     */
    protected function getEmployeeByIdWithCompany(?int $id)
    {
        return Employee::filterById($id)->with('company')->get()->toArray();
    }
}
