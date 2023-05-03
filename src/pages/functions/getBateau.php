<?php
require '../../../vendor/autoload.php';

use Dotenv\Dotenv;

session_start();



// Récupére le nom de la liaison précédemment sélectionnéé
if (isset($_POST['dispoLiaison'])) {
    // Récupérez la valeur sélectionnée de la liste déroulante
    $valeurLiaisons = $_POST['dispoLiaison'];
    $valeurLiaisonsExplode = explode('|', $valeurLiaisons);

    // Enregistrez la valeur sélectionnée dans la variable de session
    $_SESSION['nomLiaisons'] = $valeurLiaisonsExplode[1];
}

// Récupére la date de la liaison précédemment sélectionnéé
if (isset($_POST['dispoDate'])) {
    // Récupérez la valeur sélectionnée de la liste déroulante
    $valeurDate = $_POST['dispoDate'];
    $valeurDateExplode = explode('|', $valeurDate);

    // Enregistrez la valeur sélectionnée dans la variable de session
    $_SESSION['traversee'] = $valeurDateExplode[0];
    $_SESSION['date'] = $valeurDateExplode[1];
    $_SESSION['heure'] = $valeurDateExplode[2];
}
$idBateau = intval($_SESSION['idBateau']);

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
    $checkDispo = "SELECT *
            FROM bateau 
            WHERE id_bateau = ? ;";
    $checkResultDispo = $db->prepare($checkDispo, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $checkResultDispo->bindParam(1, $idBateau, PDO::PARAM_INT);



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
        $result = $checkResultDispo->fetch();
        $libelleBateau = $result['libelle_bateau'];
        $vitesse = $result['vitesse'];
        $longueur = $result['longueur'];
        $largeur = $result['largeur'];
        $_SESSION['libelleBateau'] = $libelleBateau;
        $_SESSION['vitesse'] = $vitesse;
        $_SESSION['longueur'] = $longueur;
        $_SESSION['largeur'] = $largeur;
        header('Location: ./getPlaces.php');
    } else {
        $_SESSION["erreurMessageDispo"] = "Pas de bateau disponible pour cette liaison.";
        $_SESSION["erreurTypeDispo"] = 5;
    }
} catch (PDOException $e) {
    echo "error";
    $_SESSION["erreurMessageDispo"] = "La connexion à la base de donnée n'est pas établie : " . $e->getCode() . $e->getMessage();
    $_SESSION["erreurTypeDispo"] = 1;

    die("Erreur de connexion : " . $e->getCode() . $e->getMessage());
}
