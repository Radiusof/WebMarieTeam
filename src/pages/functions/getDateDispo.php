<?php
session_start();
$liaison = $_REQUEST["liaison"];
$_SESSION['liaison'] = $liaison;

try {

    // Connexion à la base de données
    $dsn = "mysql:host=localhost;dbname=marieteam;charset=utf8";
    $opt = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );
    $db = new PDO($dsn, "supAdmin", "4uFw9is0/qUxZ)Wh", $opt);

    $_SESSION["erreurMessageDispo"] = "";
    //Requête pour récuper les dates disponibles pour la liaison sélectionnée.
    $checkDispo = "SELECT DISTINCT date_depart, id_traversee, heure
            FROM travers 
            WHERE id_liaison = ? ;";
    $checkResultDispo = $db->prepare($checkDispo, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $checkResultDispo->bindParam(1, $liaison, PDO::PARAM_INT);


    if (!$checkResultDispo->execute()) {
        $_SESSION["erreurMessageDispo"] = "Erreur lors de la requête.";
        $_SESSION["erreurTypeDispo"] = 1;
        //header('Location: ../../public/pages/index.php');
        die();
    }
    $row_count = $checkResultDispo->rowCount();

    if ($row_count > 0) {
        $result = $checkResultDispo->fetchAll();
        // Générer la liste déroulante avec les résultats de la requête
        echo "<label class=\"d-block\"> Date / Horaires disponibles: </label>";
        echo "<select name='dispoDate'  onchange='getHoraire(this.value)' >";
        foreach ($result as $resultat) {
            $newDate = date("d-m-Y", strtotime($resultat['date_depart']));
            echo "<option value='" . $resultat['id_traversee'] .  "|" . $newDate . "|" . $resultat['heure'] . "'>" . $newDate . " - " . $resultat['heure'] .  "</option>";
        }
        echo "</select>" . "<br>";
    } else {
        $_SESSION["erreurMessageDispo"] = "Pas de date disponible pour cette liaison.";
        $_SESSION["erreurTypeDispo"] = 5;
    }
} catch (PDOException $e) {
    echo "error";
    $_SESSION["erreurMessageDispo"] = "La connexion à la base de donnée n'est pas établie : " . $e->getCode() . $e->getMessage();
    $_SESSION["erreurTypeDispo"] = 1;

    die("Erreur de connexion : " . $e->getCode() . $e->getMessage());
}
