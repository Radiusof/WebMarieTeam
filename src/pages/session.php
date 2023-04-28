<?php
session_start();

if(isset($_SESSION["nomUser"]) && $_SESSION["nomUser"] === true){
    header("Location: index.php");
    exit;
}
?>