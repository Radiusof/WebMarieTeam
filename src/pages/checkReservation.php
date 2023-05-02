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
    $villeResa = $_POST['VilleResa'];
    $_SESSION["VilleResa"] = $villeResa;
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
    $cumulNombreA = 0;
    $totalCatB = 0;
    $cumulNombreB = 0;
    $totalCatC = 0;
    $cumulNombreC = 0;
    $totalCoutResa = 0;

    for ($i = 0; $i < count($nombreResa); $i++) {
        $nombre = $nombreResa[$i];
        $tarif = $tarifResa[$i];

        // Categorie A
        if ($i < 3) {
            $totalCatA += $nombre * $tarif;
            $cumulNombreA += $nombre;

            // Categorie B
        } else if ($i < 5) {
            $totalCatB += $nombre * $tarif;
            $cumulNombreB += $nombre;
            // Categorie C
        } else {
            $totalCatC += $nombre * $tarif;
            $cumulNombreC += $nombre;
        }
    }
    $totalCoutResa = $totalCatA + $totalCatB + $totalCatC;
    $_SESSION['totalPrix'] = $totalCoutResa;

    // Génération d'un numéro de réservation unique.
    $numero_reservation_unique = genererNumeroReservationUnique();
    $_SESSION['numeroResa'] = $numero_reservation_unique;

    $totalNombreCat = array();

    for ($i = 0; $i < 3; $i++) {
        if ($i < 1) {
            $totalNombreCat[] = $cumulNombreA;
        } else if ($i < 2) {
            $totalNombreCat[] = $cumulNombreB;
        } else if ($i < 3) {
            $totalNombreCat[] = $cumulNombreC;
        }
    }

    // initialiser le tableau des libelles_type
    $libelles_type_selectionnes = array();
    $nombre_selectionnes = array();
    // parcourir les inputs de chaque ligne
    foreach ($nombreResa as $index => $nombre) {
        if ($nombre > 0) {
            // si le nombre est supérieur à zéro, ajouter le libelle_type correspondant dans le tableau
            $libelles_type_selectionnes[] = $libelleResa[$index] . " - " . $nombre;
            $nombre_selectionnes[] = $nombre;
        }
    }
    //TODO RECUPERE NOMBRE SELECTIONNE POUR LE SOUSTRAIRE A CAPACITE MAX
    $_SESSION['libellesSelect'] = $libelles_type_selectionnes;
    $_SESSION['nombresSelect'] = $nombre_selectionnes;
    $_SESSION['totalNombreCat'] = $totalNombreCat;

    // afficher le résultat
    //echo "Les libelles_type sélectionnés sont :  <br> " . implode(" <br> ", $_SESSION['libellesSelect']);
    //echo "Id_Utilisateur: " . $_SESSION['idUser'];

    try {
        // Connexion à la base de données
        $dsn = "mysql:host=localhost;dbname=marieteam;charset=utf8";
        $opt = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        $db = new PDO($dsn, "supAdmin", "4uFw9is0/qUxZ)Wh", $opt);


        // Vérifie si le code Postal est valide
        if (strlen($CPResa) < 5) {
            $_SESSION["erreurMessageResa"] = "Le code postal n'est pas au bon format!";
            $_SESSION["erreurTypeResa"] = 6;
            header('Location: ../../public/pages/confirmResa.php');
        }

        //Mets à jour la capacité Max de chaque catégorie

        $valeurs = $_SESSION['capaciteMax'];
        foreach ($valeurs as $index => $valeur) {
            $capaciteMax = $valeur;
            echo "Capacite Max: " .  $capaciteMax . "<br>";

            echo "Index: " .  $index . "<br>";
            $nombreSelect = $_SESSION['totalNombreCat'][$index];
            echo "Nombre à soustraire: " .  $nombreSelect . "<br>";
            $newCapacite = $capaciteMax - $nombreSelect;
            echo "New Capacite Max: " .  $newCapacite . "<br><br>";
            $categorie = $index + 1;

            $updateQuery = "UPDATE contenir SET capaciteMax = ?  WHERE id_traversee = ? AND id_categorie = ? AND capaciteMax - ? >= 0;";
            $checkResultUpdate = $db->prepare($updateQuery);
            $checkResultUpdate->bindParam(1, $newCapacite, PDO::PARAM_INT);
            $checkResultUpdate->bindParam(2, $_SESSION['traversee'], PDO::PARAM_INT);
            $checkResultUpdate->bindParam(3, $categorie, PDO::PARAM_INT);
            $checkResultUpdate->bindParam(4, $capaciteMax, PDO::PARAM_INT);
            //Verification si l'insert a bien été effectué.
            if (!$checkResultUpdate->execute()) {
                $_SESSION["erreurMessageSignUp"] = "Erreur lors de l'update!";
                $_SESSION["erreurTypeSignUp"] = 5;
                //header('Location: ../../public/pages/confirmResa.php');
                echo "error boucle insert";
                die();
            }
        }

        echo "id_traversée: " .  $_SESSION['traversee'];

        //Requête pour récuper les capaciteMax disponibles pour la liaison sélectionnée.
        $checkDispo = "SELECT *
        FROM contenir 
        WHERE id_traversee = ? ;";
        $checkResultDispo = $db->prepare($checkDispo, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $checkResultDispo->bindParam(1, $_SESSION['traversee'], PDO::PARAM_INT);



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

            $valeurs = $_SESSION['capaciteMax'];
            foreach ($valeurs as $valeur) {
                echo "New capacité Max :" . $valeur;
            }
            //header('Location: ./getTarifByDate.php');
        } else {
            $_SESSION["erreurMessageDispo"] = "Pas de places disponible pour cette liaison.";
            $_SESSION["erreurTypeDispo"] = 5;
        }


        //Requete Insert
        $insertQuery = "INSERT INTO reservation (id_reservation, nom, adresse, cp, ville, id_traversee , id_utilisateur) 
        VALUES (?,?,?,?,?,?,?)";
        $checkResultInsert = $db->prepare($insertQuery);
        $checkResultInsert->bindParam(1, $numero_reservation_unique, PDO::PARAM_INT);
        $checkResultInsert->bindParam(2, $nom, PDO::PARAM_STR);
        $checkResultInsert->bindParam(3, $adresseResa, PDO::PARAM_STR);
        $checkResultInsert->bindParam(4, $CPResa, PDO::PARAM_STR);
        $checkResultInsert->bindParam(5, $villeResa, PDO::PARAM_STR);
        $checkResultInsert->bindParam(6, $_SESSION['traversee'], PDO::PARAM_INT);
        $checkResultInsert->bindParam(7, $_SESSION['idUser'], PDO::PARAM_INT);

        //Verification si l'insert a bien été effectué.
        if (!$checkResultInsert->execute()) {
            $_SESSION["erreurMessageSignUp"] = "Erreur lors de l'ajout!";
            $_SESSION["erreurTypeSignUp"] = 5;
            header('Location: ../../public/pages/confirmResa.php');
        }
        //Renvoie vers la page de confirmation de Réservation réussi
        header('Location: ../../public/pages/successResa.php');
    } catch (PDOException $e) {
        echo "error";
        $_SESSION["erreurMessageResa"] = "La connexion à la base de donnée n'est pas établie"  . $e->getCode() . $e->getMessage();
        $_SESSION["erreurTypeResa"] = 1;

        header('Location: ../../public/pages/confirmResa.php');
        die("Erreur de connexion : " . $e->getCode() . $e->getMessage());
    }
}
