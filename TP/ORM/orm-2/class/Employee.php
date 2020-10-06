<?php

class Employee extends Entity {

    /**
     * Liste des propriétés
     */
    private int $employee_id;
    private ?string  $first_name;
    private ?string $last_name;
    private ?string $email;
    private ?string $phone_number;
    private $hire_date;
    private ?int $job_id;
    private ?float $salary;
    private ?int $manager_id;
    private ?int $department_id;
    private ?Department $department;
    private ?string $gender;


    /**
     * @return mixed
     */
    public function getEmployeeId(): int
    {
        return $this->employee_id;
    }

    public function setDepartment(Department $department): void
    {
        $this->department = $department;
        $this->department_id = $department->getDepartmentId();
    }

    /**
     * @return mixed
     */
    public function getDepartmentId(): ?int
    {
        return $this->department_id;
    }

    /**
     * @return mixed
     */
    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    /**
     * @return mixed
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @return mixed
     */
    public function getHireDate()
    {
        return $this->hire_date;
    }

    /**
     * @return mixed
     */
    public function getJobId(): ?int
    {
        return $this->job_id;
    }

    /**
     * @return mixed
     */
    public function getManagerId(): ?int
    {
        return $this->manager_id;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * @return mixed
     */
    public function getSalary(): ?float
    {
        return $this->salary;
    }

    /**
     * @param mixed $department_id
     */
    public function setDepartmentId($department_id)
    {
        $this->department_id = $department_id;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param mixed $employee_id
     */
    public function setEmployeeId($employee_id)
    {
        $this->employee_id = $employee_id;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @param mixed $hire_date
     */
    public function setHireDate($hire_date)
    {
        $this->hire_date = $hire_date;
    }

    /**
     * @param mixed $job_id
     */
    public function setJobId($job_id)
    {
        $this->job_id = $job_id;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * @param mixed $manager_id
     */
    public function setManagerId($manager_id)
    {
        $this->manager_id = $manager_id;
    }

    /**
     * @param mixed $phone_number
     */
    public function setPhoneNumber($phone_number)
    {
        $this->phone_number = $phone_number;
    }

    /**
     * @param mixed $salary
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;
    }

    public function getId()
    {
        return $this->employee_id;
    }
}