<?php
$backtrace = debug_backtrace();
$callerFile = $backtrace[0]['file']; 


if (strpos($callerFile, 'gerenciamento') !== false || strpos($callerFile, 'cadastro') !== false  || strpos($callerFile, 'editar') !== false) {
    include_once "../classes/Database.php";
} else {
    include_once "./classes/Database.php";
}

$database = new Database();
$db = $database->getConnection();
?>