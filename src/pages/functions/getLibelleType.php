<?php
require '../../../vendor/autoload.php';

use Dotenv\Dotenv;

session_start();


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
    $checkDispo = "SELECT libelle_type
            FROM type ;";
    $checkResultDispo = $db->prepare($checkDispo, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

    if (!$checkResultDispo->execute()) {
        $_SESSION["erreurMessageDispo"] = "Erreur lors de la requête.";
        $_SESSION["erreurTypeDispo"] = 1;
        //header('Location: ../../public/pages/index.php');
        die();
    }


    $row_count = $checkResultDispo->rowCount();

    if ($row_count > 0) {
        $result = $checkResultDispo->fetchAll();
        $libelleType = array_column($result, 'libelle_type');
        $_SESSION['libelle_type'] = $libelleType;
        header('Location: ../../../public/pages/confirmResa.php');
    } else {
        $_SESSION["erreurMessageDispo"] = "Pas de libelle pour cette liaison.";
        $_SESSION["erreurTypeDispo"] = 5;
    }
} catch (PDOException $e) {
    echo "error";
    $_SESSION["erreurMessageDispo"] = "La connexion à la base de donnée n'est pas établie : " . $e->getCode() . $e->getMessage();
    $_SESSION["erreurTypeDispo"] = 1;

    die("Erreur de connexion : " . $e->getCode() . $e->getMessage());
}
