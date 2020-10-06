<?php


class EmployeeService extends AbstractService
{
    protected $_columns = [
        'employee_id',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'hire_date',
        'job_id',
        'salary',
        'manager_id',
        'department_id',
        'gender',
    ];

    protected $_tableName = "employees";
    protected $_primaryKey = "employee_id";
    protected $_entityClass = Employee::class;

    public function getAll(): array {
        $employees = parent::getAll();

        $dptService = new DepartmentService();

        /**
         * @var Employee $e
         */
        foreach ($employees as $e) {
            $e->setDepartment($dptService->getById($e->getDepartmentId()));
        }

        return $employees;
    }

    public function getById(int $id): Employee {
        $employee = parent::getById($id);

        $dptService = new DepartmentService();

        /**
         * @var Employee $employee
         */

        $employee->setDepartment($dptService->getById($employee->getDepartmentId()));

        return $employee;
    }
}