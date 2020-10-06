<?php


class Department {
    private $department_id;
    private $department_name;
    private $location_id;

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
    public function getDepartmentName()
    {
        return $this->department_name;
    }

    /**
     * @return mixed
     */
    public function getLocationId()
    {
        return $this->location_id;
    }

    /**
     * @param mixed $department_id
     */
    public function setDepartmentId($department_id)
    {
        $this->department_id = $department_id;
    }

    /**
     * @param mixed $department_name
     */
    public function setDepartmentName($department_name)
    {
        $this->department_name = $department_name;
    }

    /**
     * @param mixed $location_id
     */
    public function setLocationId($location_id)
    {
        $this->location_id = $location_id;
    }

    public function getId()
    {
        return $this->department_id;
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