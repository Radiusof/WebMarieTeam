<?php
session_start();
$date = $_SESSION["date"];
$idLiaison = $_REQUEST["id"];

$erreurMessageDispo = "";
try {
    // Connexion à la base de données
    $dsn = "mysql:host=localhost;dbname=marieteam;charset=utf8";
    $opt = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );
    $db = new PDO($dsn, "supAdmin", "4uFw9is0/qUxZ)Wh", $opt);
    $_SESSION["erreurMessageDispo"] = "";
    //Requête pour récuper les liaisons disponibles a la période sélectionnée.
    $checkHoraire = "SELECT * 
            FROM travers 
            WHERE date_depart = ? 
            AND id_liaison = ?";
    $checkHoraireDispo = $db->prepare($checkHoraire);
    $checkHoraireDispo->bindParam(1, $date, PDO::PARAM_STR);
    $checkHoraireDispo->bindParam(2, $idLiaison, PDO::PARAM_INT);

    if (!$checkHoraireDispo->execute()) {
        $_SESSION["erreurMessageDispo"] = "Erreur lors de la requête.";
        $_SESSION["erreurTypeDispo"] = 1;

        //header('Location: ../../public/pages/index.php');
        die();
    }
    $count = 0;

    // Créer la liste déroulante
    echo "<label class=\"d-block\"> Horaires disponibles: </label>";
    echo "<select name='dispoLiaison'>";
    while ($row = $checkHoraireDispo->fetch()) {
        echo "<option value='" . $row['id_traversee'] . "'>" . $row['heure'] . "</option>";
        $count++;
    }
    echo "</select>" . "<br>";

    if ($count = 0) {
        $_SESSION["erreurMessageDispo"] = "Pas d'horaires disponibles pour cette liaison à cette date.";
        $_SESSION["erreurTypeDispo"] = 5;

        //header('Location: ../../public/pages/index.php');
        die();
    }
} catch (PDOException $e) {
    echo "error";
    $_SESSION["erreurMessageDispo"] = "La connexion à la base de donnée n'est pas établie : " . $e->getCode() . $e->getMessage();
    $_SESSION["erreurTypeDispo"] = 1;

    header('Location: ../../public/pages/index.php');
    die("Erreur de connexion : " . $e->getCode() . $e->getMessage());
}
