<?php
require '../../../vendor/autoload.php';

use Dotenv\Dotenv;

session_start();

$date = $_SESSION["date"];
$idLiaison = $_REQUEST["id"];

$erreurMessageDispo = "";
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

    $row_count = $checkHoraireDispo->rowCount();

    if ($row_count > 0) {
        $result = $checkHoraireDispo->fetchAll();
        // Générer la liste déroulante avec les résultats de la requête
        echo "<label class=\"d-block\"> Horaires disponibles: </label>";
        echo "<select name='dispHoraires'>";
        foreach ($result as $resultat) {
            echo '<option value="' . $resultat['id_traversee'] . '">' . $resultat['heure'] . '</option>';
        }
        echo "</select>" . "<br>";
    } else {
        $_SESSION["erreurMessageDispo"] = "Pas d'horaires disponibles pour cette liaison à cette date.";
        $_SESSION["erreurTypeDispo"] = 5;
    }
} catch (PDOException $e) {
    echo "error";
    $_SESSION["erreurMessageDispo"] = "La connexion à la base de donnée n'est pas établie : " . $e->getCode() . $e->getMessage();
    $_SESSION["erreurTypeDispo"] = 1;

    header('Location: ../../public/pages/index.php');
    die("Erreur de connexion : " . $e->getCode() . $e->getMessage());
}
