<?php
if(!isset($_SESSION)){
    session_start();
}

$user = $_SESSION['user'];

if(!isset($user)){
    session_destroy();
    header("Location: index.php");
    die();
}
?>