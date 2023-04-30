<?php
session_start();
$date = $_SESSION["date"];
$secteur = $_REQUEST["secteur"];



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
    $checkDispo = "SELECT * 
            FROM liaison 
            WHERE id_secteur = ? 
            AND id_liaison IN (
                SELECT id_liaison
                FROM tarifer 
                WHERE id_periode  IN ( 
                    SELECT id_periode 
                    FROM periode
                    WHERE ? BETWEEN debut AND fin AND ? IN (
                        SELECT date_depart
                        FROM travers
                    )
                )
            )";
    $checkResultDispo = $db->prepare($checkDispo);
    $checkResultDispo->bindParam(1, $secteur, PDO::PARAM_INT);
    $checkResultDispo->bindParam(2, $date, PDO::PARAM_STR);
    $checkResultDispo->bindParam(3, $date, PDO::PARAM_STR);

    if (!$checkResultDispo->execute()) {
        $_SESSION["erreurMessageDispo"] = "Erreur lors de la requête.";
        $_SESSION["erreurTypeDispo"] = 1;

        //header('Location: ../../public/pages/index.php');
        die();
    }

    // Créer la liste déroulante
    echo "<label class=\"d-block\"> Liaisons: </label>";
    echo "<select name='dispoLiaison' onchange='getHoraires(this.value)'>";
    while ($row = $checkResultDispo->fetch()) {
        echo "<option value='" . $row['id_liaison'] . "'>" . $row['port_depart'] . " - " . $row['port_arrivee'] . "</option>";
    }
    echo "</select>" . "<br>";
} catch (PDOException $e) {
    echo "error";
    $_SESSION["erreurMessageDispo"] = "La connexion à la base de donnée n'est pas établie : " . $e->getCode() . $e->getMessage();
    $_SESSION["erreurTypeDispo"] = 1;

    //header('Location: ../../public/pages/index.php');
    die("Erreur de connexion : " . $e->getCode() . $e->getMessage());
}
