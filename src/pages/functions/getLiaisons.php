<?php
require '../../../vendor/autoload.php';

use Dotenv\Dotenv;

session_start();


$secteur = $_REQUEST["secteur"];
$_SESSION['secteur'] = $secteur;

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
    //Requête pour récuper les liaisons disponibles au secteur sélectionnée.
    $checkDispo = "SELECT * 
            FROM liaison 
            WHERE id_secteur = ? ;";
    $checkResultDispo = $db->prepare($checkDispo);
    $checkResultDispo->bindParam(1, $secteur, PDO::PARAM_INT);


    if (!$checkResultDispo->execute()) {
        $_SESSION["erreurMessageDispo"] = "Erreur lors de la requête.";
        $_SESSION["erreurTypeDispo"] = 1;

        //header('Location: ../../public/pages/index.php');
        die();
    }

    $row_count = $checkResultDispo->rowCount();

    if ($row_count > 0) {
        $result = $checkResultDispo->fetchAll();
        $nomLiaison = "";
        // Générer la liste déroulante avec les résultats de la requête
        echo "<label class=\"d-block\"> Liaisons: </label>";
        echo "<select name='dispoLiaison' onchange='getDateDispo(this.value)'>";
        foreach ($result as $resultat) {
            $nomLiaison = $resultat['port_depart'] . " - " . $resultat['port_arrivee'];
            echo "<option value='" . $resultat['id_liaison'] . "|" . $nomLiaison . "'>" . $nomLiaison . "</option>";
        }
        echo "</select>" . "<br>";
        exit();
    } else {
        $_SESSION["erreurMessageDispo"] = "Pas de liaison disponible dans ce secteur.";
        $_SESSION["erreurTypeDispo"] = 5;
        die();
    }
} catch (PDOException $e) {
    echo "error";
    $_SESSION["erreurMessageDispo"] = "La connexion à la base de donnée n'est pas établie : " . $e->getCode() . $e->getMessage();
    $_SESSION["erreurTypeDispo"] = 1;

    //header('Location: ../../public/pages/index.php');
    die("Erreur de connexion : " . $e->getCode() . $e->getMessage());
}
