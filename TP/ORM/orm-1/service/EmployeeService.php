<?php


class EmployeeService
{
    protected PDO $_db;
    protected DepartmentService $_departmentService;

    const TABLE_NAME = 'employees';
    const PRIMARY_KEY = 'employee_id';

    /**
     * EmployeeService constructor.
     */
    public function __construct()
    {
        try {
            $this->_db = new PDO('mysql:host=localhost:3390;dbname=employee', 'root', 'example');
            $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->_departmentService = new DepartmentService();
        } catch (Exception $e) {
            echo 'Une erreur a eu lieu à l\'instanciation du service ' . __CLASS__ . ' => ' . $e->getMessage();
        }
    }

    /**
     * Insert un employé dans la base de données
     *
     * @param Employee $employee
     */
    public function insert(Employee $employee): void
    {
        $sql = 'INSERT INTO ' . self::TABLE_NAME .
            ' (first_name, last_name, email, phone_number, hire_date, job_id, salary, manager_id, department_id, gender) ' .
            ' VALUES (:first_name, :last_name, :email, :phone_number, :hire_date, :job_id, :salary, :manager_id, :department_id, :gender)';

        $query = $this->_db->prepare($sql);

        $query = $this->bindData($query, $employee);

        $query->execute();
    }

    /**
     * Bind les paramètres de l'employé dans la requête SQL
     *
     * @param PDOStatement $query
     * @param Employee $employee
     * @return PDOStatement
     */
    private function bindData(PDOStatement $query, Employee $employee): PDOStatement {
        $query->bindValue(':first_name', $employee->getFirstName());
        $query->bindValue(':last_name', $employee->getLastName());
        $query->bindValue(':email', $employee->getEmail());
        $query->bindValue(':phone_number', $employee->getPhoneNumber());
        $query->bindValue(':hire_date', $employee->getHireDate());
        $query->bindValue(':job_id', $employee->getJobId());
        $query->bindValue(':salary', $employee->getSalary());
        $query->bindValue(':manager_id', $employee->getManagerId());
        $query->bindValue(':department_id', $employee->getDepartment()->getDepartmentId());
        $query->bindValue(':gender', $employee->getGender());

        if ($employee->getEmployeeId()) {
            $query->bindValue(':employee_id', $employee->getEmployeeId());
        }

        return $query;
    }

    /**
     * Récupère un employé dans la BDD en fonction de son identifiant
     *
     * @return Employee
     */
    public function getEmployeeById(int $employee_id): Employee {
        $sql = 'SELECT * FROM ' . self::TABLE_NAME . ' WHERE ' . self::PRIMARY_KEY . ' = :employee_id';
        $query = $this->_db->prepare($sql);
        $query->bindValue(':employee_id', $employee_id);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $employee = new Employee();
        $employee->hydrate($result);
        $employee->setDepartment($this->_departmentService->getDepartmentById($result['department_id']));

        return $employee;
    }
    /**
     *  Retourne la liste de tous les employés
     *
     * @return Employee[]
     */
    public function getAllEmployees(): array {
        $sql = 'SELECT * FROM ' . self::TABLE_NAME;
        $query = $this->_db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $emps = [];

        foreach ($result as $data) {
            $employee = new Employee();
            $employee->hydrate($data);
            $employee->setDepartment($this->_departmentService->getDepartmentById($data['department_id']));
            $emps[] = $employee;
        }

        return $emps;
    }

    /**
     * Met à jour un employé dans la base de données
     *
     * @param Employee $employee
     */
    public function update(Employee $employee): void
    {
        $sql = 'UPDATE ' . self::TABLE_NAME .
            ' SET first_name = :first_name,
            last_name = :last_name,
            email = :email,
            phone_number = :phone_number,
            hire_date = :hire_date,
            job_id = :job_id,
            salary = :salary,
            manager_id = :manager_id,
            department_id = :department_id,
            gender = :gender
            WHERE '. self::PRIMARY_KEY. ' = :employee_id';

        $query = $this->_db->prepare($sql);

        $query = $this->bindData($query, $employee);

        $query->execute();
    }

    /**
     * Supprime un employé de la base de données
     *
     * @param Employee $employee
     */
    public function delete(Employee $employee): void
    {
        $sql = 'DELETE FROM ' . self::TABLE_NAME .
            ' WHERE '. self::PRIMARY_KEY. ' = :employee_id';

        $query = $this->_db->prepare($sql);

        $query->bindValue(':employee_id', $employee->getEmployeeId());

        $query->execute();
    }
}