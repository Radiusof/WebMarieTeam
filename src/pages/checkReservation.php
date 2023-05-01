<?php
// ../../src/pages/successResa.php 
session_start();
include_once('./functions/getNumeroResa.php');
$error_type_resa = $error_message_resa = "";
// Vérification de la soumission du formulaire
if (isset($_POST['submitResa'])) {
    // Récupération des valeurs du formulaire
    $nom = $_POST['nomResa'];
    $_SESSION["nomResa"] = $nom;
    $adresseResa = $_POST['adresseResa'];
    $_SESSION["adresseResa"] = $adresseResa;
    $CPResa = $_POST['CPResa'];
    $_SESSION["CPResa"] = $CPResa;
    $VilleResa = $_POST['VilleResa'];
    $_SESSION["VilleResa"] = $VilleResa;
    $libelleResa = $_POST['libelleResa'];
    $tarifResa = $_POST['tarifResa'];
    $nombreResa = $_POST['nombreResa'];


    //Initialise les variables d'erreurs.
    $error_message_resa = "";
    $_SESSION["erreurMessageResa"] = $error_message_resa;
    $error_type_resa = 0;
    $_SESSION["erreurTypeResa"] = $error_type_resa;

    //Addition des coûts / Vérification des valeurs $_POST

    $totalCatA = 0;
    $totalCatB = 0;
    $totalCatC = 0;
    $totalCoutResa = 0;

    for ($i = 0; $i < count($nombreResa); $i++) {
        $nombre = $nombreResa[$i];
        $tarif = $tarifResa[$i];

        if ($i < 3) {
            $totalCatA += $nombre * $tarif;
        } else if ($i < 5) {
            $totalCatB += $nombre * $tarif;
        } else {
            $totalCatC += $nombre * $tarif;
        }
    }
    $totalCoutResa = $totalCatA + $totalCatB + $totalCatC;

    echo "Total A: " . $totalCatA . "€<br>";
    echo "Total B: " . $totalCatB . "€<br>";
    echo "Total C: " . $totalCatC . "€<br>";
    echo "Total Cout Resa: " . $totalCoutResa . "€<br>";

    echo "Nom: " . $nom . "<br>";
    echo "Adresse: " . $adresseResa . "<br>";
    echo "CP: " . $CPResa . "<br>";
    echo "Ville: " . $VilleResa . "<br>";

    // Génération d'un numéro de réservation unique.
    $numero_reservation_unique = genererNumeroReservationUnique();
    echo "Numéro de Réservation: " . $numero_reservation_unique . "<br>";

    // initialiser le tableau des libelles_type
    $libelles_type_selectionnes = array();

    // parcourir les inputs de chaque ligne
    foreach ($nombreResa as $index => $nombre) {
        if ($nombre > 0) {
            // si le nombre est supérieur à zéro, ajouter le libelle_type correspondant dans le tableau
            $libelles_type_selectionnes[] = $libelleResa[$index];
        }
    }

    // afficher le résultat
    echo "Les libelles_type sélectionnés sont :  <br> " . implode(" <br> ", $libelles_type_selectionnes);
    /*
    try {
        // Connexion à la base de données
        $dsn = "mysql:host=localhost;dbname=marieteam;charset=utf8";
        $opt = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        $db = new PDO($dsn, "supAdmin", "4uFw9is0/qUxZ)Wh", $opt);
        echo "start db";

        echo "check email";
        //Vérifie le format email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION["erreurMessageResa"] = "Le format de l'email est invalide!";
            $_SESSION["erreurTypeResa"] = 0;

            header('Location: ../../public/pages/login.php');
            die();
        }

        //Requête pour récuper le hash du mdp dans la bdd
        $checkMdp = "SELECT password FROM utilisateur WHERE email = ? ";
        $checkResultMdp = $db->prepare($checkMdp);
        $checkResultMdp->bindParam(1, $email, PDO::PARAM_STR);
        echo "check query";
        if (!$checkResultMdp->execute()) {
            $_SESSION["erreurMessageResa"] = "Erreur lors de la requête.";
            $_SESSION["erreurTypeResa"] = 1;

            header('Location: ../../public/pages/login.php');
            die();
        }
        echo "check mail db";
        if ($checkResultMdp->rowCount() == 0) {
            $_SESSION["erreurMessageResa"] = "L'adresse email renseigné n'existe pas, veuillez réesssayer ou créer un compte.";
            $_SESSION["erreurTypeResa"] = 2;

            header('Location: ../../public/pages/login.php');
            die();
        }

        $hashMdp = $checkResultMdp->fetchColumn();

        //Vérifie si le mdp correspond  à celle de la bdd
        echo "check mdp";
        if (!password_verify($mdp, $hashMdp)) {
            $_SESSION["erreurMessageResa"] = "Mot de passe incorrect!";
            $_SESSION["erreurTypeResa"] = 3;

            header('Location: ../../public/pages/login.php');
            die();
        }
        //Si ok, recupere le nom utilisateur pour la sauvegarder sur la session
        $checkNom = "SELECT prenom FROM utilisateur WHERE email = ? ";
        $checkResultNom = $db->prepare($checkNom);
        $checkResultNom->bindParam(1, $email, PDO::PARAM_STR);
        echo "check nom";
        if (!$checkResultNom->execute()) {
            $_SESSION["erreurMessageResa"] = "Erreur lors de la requête.";
            $_SESSION["erreurTypeResa"] = TRUE;

            header('Location: ../../public/pages/login.php');
            die();
        }

        //Renvoie vers la page d'accueil
        $_SESSION["nomUser"] = $checkResultNom->fetchColumn();
        $_SESSION["loggedIn"] = true;
        header('Location: ../../public/pages/index.php');
        die();
    } catch (PDOException $e) {
        echo "error";
        $_SESSION["erreurMessageResa"] = "La connexion à la base de donnée n'est pas établie"  . $e->getCode() . $e->getMessage();
        $_SESSION["erreurTypeResa"] = 1;

        header('Location: ../../public/pages/login.php');
        die("Erreur de connexion : " . $e->getCode() . $e->getMessage());
    }
    */
}
