<?php
function genererNumeroReservationUnique()
{
    //Genere un numéro
    $numero_reservation = genererNumeroReservation(); // générer un numéro de réservation
    try {

        // Connexion à la base de données
        $dsn = "mysql:host=localhost;dbname=marieteam;charset=utf8";
        $opt = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        $db = new PDO($dsn, "supAdmin", "4uFw9is0/qUxZ)Wh", $opt);

        $_SESSION["erreurMessageResa"] = "";
        //Requête pour vérifier si le numéro de reservation existe.
        $checkDispo = "SELECT COUNT(*)
                FROM reservation 
                WHERE id_reservation = ? ;";
        $checkResultDispo = $db->prepare($checkDispo, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $checkResultDispo->bindParam(1, $numero_reservation, PDO::PARAM_INT);



        if (!$checkResultDispo->execute()) {
            $_SESSION["erreurMessageResa"] = "Erreur lors de la requête.";
            $_SESSION["eerreurTypeResa"] = 1;
            //header('Location: ../../public/pages/index.php');
            die();
        }
        $count = $checkResultDispo->fetchColumn();
        if ($count > 0) { // si le numéro de réservation existe déjà, générer un nouveau numéro
            return genererNumeroReservationUnique();
        } else { // si le numéro de réservation est unique, le retourner
            return $numero_reservation;
        }
    } catch (PDOException $e) {
        echo "error";
        $_SESSION["erreurMessageResa"] = "La connexion à la base de donnée n'est pas établie : " . $e->getCode() . $e->getMessage();
        $_SESSION["eerreurTypeResa"] = 1;

        die("Erreur de connexion : " . $e->getCode() . $e->getMessage());
    }
}

function genererNumeroReservation()
{
    $numeroReservation = rand(10000000, 99999999); // génération du nombre aléatoire à 8 chiffres
    return $numeroReservation;
}
