<?php

require_once('./Model/Connection.class.php');
session_start();
$pdoBuilder = new Connection();
$db = $pdoBuilder->getDb();
if (
    (isset($_GET['ctrl']) && !empty($_GET['ctrl'])) &&
    (isset($_GET['action']) && !empty($_GET['action']))
) {
    $ctrl = $_GET['ctrl'];
    $action = $_GET['action'];
} else {
    $ctrl = 'user';
    $action = 'home';
}
require_once('./Controller/' . $ctrl . 'Controller.php');
$ctrl = $ctrl . 'Controller';
$controller = new $ctrl($db);
$controller->$action();

?>