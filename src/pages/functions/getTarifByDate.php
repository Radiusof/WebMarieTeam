<?php
require '../../../vendor/autoload.php';

use Dotenv\Dotenv;

session_start();


$date = $_SESSION['date'];
$liaison = intval($_SESSION['liaison']);

echo "Date: " . $date . "<br>";
$newDate = date("Y-m-d", strtotime($date));
echo "New Date: " . $newDate . "<br>";
try {

    // Connexion à la base de données
    $root = $_SERVER['DOCUMENT_ROOT'] . "\\MarieTeam\\";
    $dotenv = Dotenv::createImmutable($root);
    $dotenv->load();
    $dns = $_ENV['DATABASE_DNS'];
    $userDB = $_ENV['DATABASE_USER'];
    $pswdDB = $_ENV['DATABASE_PASSWORD'];
    // Connexion à la base de données
    $dsn = $dns;
    $opt = array(
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );
    $db = new PDO($dsn, $userDB, $pswdDB, $opt);

    $_SESSION["erreurMessageDispo"] = "";
    //Requête pour récuper les dates disponibles pour la liaison sélectionnée.

    $checkDispo = "SELECT DISTINCT tarif
    FROM tarifer 
    WHERE id_liaison = ?
    AND id_periode IN ( 
        SELECT id_periode
        FROM periode
        WHERE  ?  BETWEEN debut AND fin 
    )";
    $checkResultDispo = $db->prepare($checkDispo, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $checkResultDispo->bindParam(1, $liaison, PDO::PARAM_INT);
    $checkResultDispo->bindParam(2, $newDate, PDO::PARAM_STR);

    if (!$checkResultDispo->execute()) {
        $_SESSION["erreurMessageDispo"] = "Erreur lors de la requête.";
        $_SESSION["erreurTypeDispo"] = 1;
        //header('Location: ../../public/pages/index.php');
        die();
    }


    $row_count = $checkResultDispo->rowCount();
    echo  "Nombre lignes: " . $row_count . "<br />";

    if ($row_count > 0) {
        echo  "Nombre lignes: " . $row_count . "<br />";
        $result = $checkResultDispo->fetchAll();
        $tarif = array_column($result, 'tarif');
        $_SESSION['tarif'] = $tarif;
        header('Location: ./getLibelleType.php');
    } else {
        $_SESSION["erreurMessageDispo"] = "Pas de tarifs disponibles pour cette liaison.";
        $_SESSION["erreurTypeDispo"] = 5;
    }
} catch (PDOException $e) {
    echo "error";
    $_SESSION["erreurMessageDispo"] = "La connexion à la base de donnée n'est pas établie : " . $e->getCode() . $e->getMessage();
    $_SESSION["erreurTypeDispo"] = 1;

    die("Erreur de connexion : " . $e->getCode() . $e->getMessage());
}
