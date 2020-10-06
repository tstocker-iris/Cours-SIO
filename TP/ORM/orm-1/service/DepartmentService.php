<?php


class DepartmentService
{
    protected $_db;

    const TABLE_NAME = 'departments';
    const PRIMARY_KEY = 'department_id';

    /**
     * DepartmentService constructor.
     */
    public function __construct()
    {
        try {
            $this->_db = new PDO('mysql:host=localhost:3390;dbname=employee', 'root', 'example');
            $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            echo 'Une erreur a eu lieu à l\'instanciation du service ' . __CLASS__ . ' => ' . $e->getMessage();
        }
    }

    /**
     * Récupère un département en BDD en fonction de son identifiant
     *
     * @param int $department_id
     * @return Department
     */
    public function getDepartmentById(int $department_id): Department {
        $sql = 'SELECT * FROM ' . self::TABLE_NAME . ' WHERE ' . self::PRIMARY_KEY . ' = :department_id';
        $query = $this->_db->prepare($sql);
        $query->bindValue(':department_id', $department_id);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $department = new Department();
        $department->hydrate($result);

        return $department;
    }

    /**
     * Renvoit la liste des départements
     *
     * @return Department[]
     */
    public function getAllDepartment(): array {
        $sql = 'SELECT * FROM ' . self::TABLE_NAME;
        $query = $this->_db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $dpts = [];

        foreach ($result as $data) {
            $dpt = new Department();
            $dpt->hydrate($data);
            $dpts[] = $dpt;
        }

        return $dpts;
    }

    /**
     * Insert un département en base de données
     *
     * @param Department $department
     * @return Department
     */
    public function insert(Department $department): Department
    {
        $sql = 'INSERT INTO ' . self::TABLE_NAME .
            ' (first_name, location_id) ' .
            ' VALUES (:department_name, :location_id)';

        $query = $this->_db->prepare($sql);

        $query = $this->bindData($query, $department);

        $query->execute();

        // On récupère le dernier identifiant ajouté pour mettre à jour notre objet
        $department->setDepartmentId($this->_db->lastInsertId());

        return $department;
    }

    /**
     * Bind les paramètres du département dans la requête SQL
     *
     * @param PDOStatement $query
     * @param Department $department
     * @return PDOStatement
     */
    private function bindData(PDOStatement $query, Department $department): PDOStatement {
        $query->bindValue(':department_name', $department->getDepartmentName());
        $query->bindValue(':location_id', $department->getLocationId());

        if ($department->getDepartmentId()) {
            $query->bindValue(':department_id', $department->getDepartmentId());
        }

        return $query;
    }

    /**
     * Met à jour un département dans la BDD
     *
     * @param Department $department
     */
    public function update(Department $department): void
    {
        $sql = 'UPDATE ' . self::TABLE_NAME .
            ' SET department_name = :department_name, 
            location_id = :location_id, 
            WHERE '. self::PRIMARY_KEY. ' = :department_id';

        $query = $this->_db->prepare($sql);

        $query = $this->bindData($query, $department);

        $query->execute();
    }

    /**
     * Supprime un département dans la BDD
     *
     * @param Department $department
     */
    public function delete(Department $department): void
    {
        $sql = 'DELETE FROM ' . self::TABLE_NAME .
            ' WHERE ' . self::PRIMARY_KEY . ' = :department_id';

        $query = $this->_db->prepare($sql);

        $query->bindValue(':department_id', $department->getDepartmentId());

        $query->execute();
    }
}
