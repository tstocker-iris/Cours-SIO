<?php


class DepartmentService extends AbstractService
{
    protected $_columns = [
        'department_id',
        'department_name',
        'location_id',
    ];

    protected $_tableName = "departments";
    protected $_primaryKey = "department_id";
    protected $_entityClass = Department::class;
}
