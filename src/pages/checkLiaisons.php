<?php
//Démarrer la session
session_start();
$_SESSION["erreurMessageDispo"] = $_SESSION["erreurTypeDispo"] = "";

if (isset($_POST['submitDispo'])) {
    if (!empty($_POST['secteur'])) {
        // Récupération des valeurs du formulaire
        $date = $_POST['dateSelect'];
        $_SESSION["date"] = $date;
        $secteur = $_POST['secteur'];
        $_SESSION["secteur"] = $secteur;
        $error_message_dispo = "";
        $_SESSION["erreurMessageDispo"] = $error_message_dispo;
        $error_type_dispo = 0;
        $_SESSION["erreurTypeDispo"] = $error_type_dispo;

        header('Location: ../../public/pages/Reservation.php');
    } else {
        $_SESSION["erreurMessageDispo"] = "Veuillez choisir un secteur.";
        $_SESSION["erreurTypeDispo"] = 10;

        header('Location: ../../public/pages/index.php');
    }
}
