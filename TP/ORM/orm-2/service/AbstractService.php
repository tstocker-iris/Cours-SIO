<?php


abstract class AbstractService {
    protected $_db;
    protected $_columns = [];

    protected $_tableName;
    protected $_primaryKey;
    protected $_entityClass;

    public function __construct()
    {
        try {
            $this->_db = new PDO('mysql:host=localhost:3390;dbname=employee', 'root', 'example');
            $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            echo 'Une erreur a eu lieu à l\'instanciation du service ' . __CLASS__ . ' => ' . $e->getMessage();
        }
    }


    public function getById(int $id) {
        $sql = 'SELECT * FROM ' . $this->_tableName . ' WHERE '
            . $this->_primaryKey . ' = :id';
        $query = $this->_db->prepare($sql);
        $query->bindValue(':id', $id);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $result = $result[0];

        $entity = new $this->_entityClass();
        $entity->hydrate($result);

        return $entity;
    }

    public function getAll(): array {
        $sql = 'SELECT * FROM ' . $this->_tableName;
        $query = $this->_db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $entities = [];

        foreach ($result as $data) {
            $entity = new $this->_entityClass();
            $entity->hydrate($data);
            $entities[] = $entity;
        }

        return $entities;
    }

    public function insert($item): void
    {
        $insert_columns = array_filter($this->_columns,
            function($item) { return $item !== $this->_primaryKey; }
        );

        $sql = 'INSERT INTO ' . $this->_tableName .
            ' (' . implode(', ', $insert_columns) . ') ' .
            ' VALUES (' . implode(', ', array_map(
                    function($c) { return ':' . $c; }
                    , $insert_columns)
            ) . ')';

        $query = $this->_db->prepare($sql);

        foreach ($insert_columns as $c) {
            /*
             * $c = 'first_name';
             */
            $columnName = explode('_', $c);
            /*
             *  $columnName = [
             *      'first',
             *      'name',
             * ];
             *
             */
            $columnName = array_map(function($i) { return ucfirst($i); }, $columnName);
            /*
             *  $columnName = [
             *      'First',
             *      'Name',
             * ];
             *
             */

            $columnName = implode('', $columnName);
            /*
             * $columnName = 'FirstName';
             */
            $method = 'get' . $columnName;
            /*
             * $method = 'getFirstName';
             */

            $method = 'get' . implode('', array_map(function($i) { return ucfirst($i); }
                    , explode('_', $c)));
            $query->bindValue(':' . $c, $item->$method());
        }

        $query->execute();
    }

    public function delete(EntityInterface $entity): void
    {
        $sql = 'DELETE FROM ' . $this->_tableName .
            ' WHERE ' . $this->_primaryKey . ' = :id';

        $query = $this->_db->prepare($sql);

        $query->bindValue(':id', $entity->getId());

        $query->execute();
    }

    private function bindData($query, $item, $columns) {
        foreach ($columns as $c) {
            /*
             * $c = 'first_name';
             */
            $columnName = explode('_', $c);
            /*
             *  $columnName = [
             *      'first',
             *      'name',
             * ];
             *
             */
            $columnName = array_map(function($i) { return ucfirst($i); }, $columnName);
            /*
             *  $columnName = [
             *      'First',
             *      'Name',
             * ];
             *
             */

            $columnName = implode('', $columnName);
            /*
             * $columnName = 'FirstName';
             */
            $method = 'get' . $columnName;
            /*
             * $method = 'getFirstName';
             */

            $method = 'get' . implode('', array_map(function($i) { return ucfirst($i); }
                    , explode('_', $c)));
            $query->bindValue(':' . $c, $item->$method());
        }

        return $query;
    }


    public function update($item): void
    {
        // Option 1;
        foreach ($this->_columns as $index => $c) {
            $set = $c . ' = :' . $c . ($index === count($this->_columns) - 1 ? '' : ',');
        }

        // Option 2;
        foreach ($this->_columns as $index => $c) {
            $set = $c . ' = :' . $c . ',';
        }
        $set = substr($set, 0, strlen($set) - 1);

        // Option 3
        $set = [];
        foreach ($this->_columns as $index => $c) {
            $set[] = $c . ' = :' . $c;
        }
        $set = implode(', ', $set);


        $sql = 'UPDATE ' . $this->_tableName .
            ' SET ' . $set . ' WHERE '. $this->_primaryKey . ' = :id';

        $query = $this->_db->prepare($sql);

        $query = $this->bindData($query, $item, $this->_columns);
        $query->bindValue(':id', $item->getId());

        $query->execute();
    }

}