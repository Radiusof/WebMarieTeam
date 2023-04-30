<?php
session_start();
// get the q parameter from URL
$q = $_REQUEST["q"];
$_SESSION["date"] = $q;

$newDate = date("d-m-Y", strtotime($q));
echo "Date sélectionnée: " . $newDate;
