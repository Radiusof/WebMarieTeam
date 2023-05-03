<?php
require '../../../vendor/autoload.php';

use Dotenv\Dotenv;

session_start();


// get the q parameter from URL
$traversee = $_REQUEST["traversee"];

// Récupére le nom de la liaison précédemment sélectionnéé
if (isset($_POST['dispoDate'])) {
    // Récupérez la valeur sélectionnée de la liste déroulante
    $valeurId = $_POST['dispoDate'];
    $valeurIdexplode = explode('|', $valeurId);

    // Enregistrez la valeur sélectionnée dans la variable de session
    $_SESSION['traversee'] = $valeurIdexplode[0];
}



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
    $checkDispo = "SELECT heure , id_bateau
            FROM travers 
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

    if ($row_count > 0) {
        $result = $checkResultDispo->fetch();
        $horaire = $result['heure'];
        $idBateau = $result['id_bateau'];
        $_SESSION['horaire'] = $horaire;
        $_SESSION['idBateau'] = $idBateau;
        echo "<br>";
        echo "<input id=\" check-availability\" class=\"btn btn-primary\" type=\"submit\" name=\"submitDispo\" value=\"Réserver!\"></input>";
    } else {
        $_SESSION["erreurMessageDispo"] = "Pas d'horaires disponible pour cette liaison.";
        $_SESSION["erreurTypeDispo"] = 5;
    }
} catch (PDOException $e) {
    echo "error";
    $_SESSION["erreurMessageDispo"] = "La connexion à la base de donnée n'est pas établie : " . $e->getCode() . $e->getMessage();
    $_SESSION["erreurTypeDispo"] = 1;

    die("Erreur de connexion : " . $e->getCode() . $e->getMessage());
}
