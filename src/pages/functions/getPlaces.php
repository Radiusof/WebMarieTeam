<?php
require '../../../vendor/autoload.php';

use Dotenv\Dotenv;

session_start();

$traversee = $_SESSION['traversee'];

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
    //Requête pour récuper les capaciteMax disponibles pour la liaison sélectionnée.
    $checkDispo = "SELECT *
            FROM contenir 
            WHERE id_traversee = ? ;";
    $checkResultDispo = $db->prepare($checkDispo, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $checkResultDispo->bindParam(1, $traversee, PDO::PARAM_INT);



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
        $capaciteMax = array_column($result, 'capaciteMax');
        $_SESSION['capaciteMax'] = $capaciteMax;
        header('Location: ./getTarifByDate.php');
    } else {
        $_SESSION["erreurMessageDispo"] = "Pas de places disponible pour cette liaison.";
        $_SESSION["erreurTypeDispo"] = 5;
    }
} catch (PDOException $e) {
    echo "error";
    $_SESSION["erreurMessageDispo"] = "La connexion à la base de donnée n'est pas établie : " . $e->getCode() . $e->getMessage();
    $_SESSION["erreurTypeDispo"] = 1;

    die("Erreur de connexion : " . $e->getCode() . $e->getMessage());
}
