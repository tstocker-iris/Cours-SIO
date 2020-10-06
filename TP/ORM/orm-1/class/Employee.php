<?php

class Employee {

    /**
     * Liste des propriétés
     */
    private $employee_id;
    private $first_name;
    private $last_name;
    private $email;
    private $phone_number;
    private $hire_date;
    private $job_id;
    private $salary;
    private $manager_id;
    private $department_id;
    private $department;
    private $gender;


    /**
     * @return mixed
     */
    public function getEmployeeId(): int
    {
        return $this->employee_id;
    }

    public function setDepartment($department): void
    {
        $this->department = $department;
    }

    public function getDepartment(): Department
    {
        return $this->department;
    }

    /**
     * @return mixed
     */
    public function getDepartmentId()
    {
        return $this->department_id;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getGender()
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
    public function getJobId()
    {
        return $this->job_id;
    }

    /**
     * @return mixed
     */
    public function getManagerId()
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
    public function getSalary()
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

    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value)
        {
            // On récupère le nom du setter correspondant à l'attribut.
            $method = 'set'.implode('', array_map(function($item) {
                        return ucfirst($item);
                    }, explode('_', $key)
                    )
                );

            // Si le setter correspondant existe.
            if (method_exists($this, $method))
            {
                // On appelle le setter.
                $this->$method($value);
            }
        }
    }
}