<?php

function chargerClass($class) {
    if (strstr(strtolower($class), 'service')) {
        require_once 'service/' . $class . '.php';
    } else {
        require_once 'class/' . $class . '.php';
    }
}

spl_autoload_register('chargerClass');

$empService = new EmployeeService();
$employee = $empService->getEmployeeById(212);

print_r($employee);

$deptService = new DepartmentService();
$department = $deptService->getDepartmentById(3);

$employee->setDepartment($department);
$empService->update($employee);

print_r($employee);

