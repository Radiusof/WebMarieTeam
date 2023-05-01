<?php

function getTarif()
{
    try {
        // Connexion à la base de données
        $dsn = "mysql:host=localhost;dbname=marieteam;charset=utf8";
        $opt = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        $db = new PDO($dsn, "supAdmin", "4uFw9is0/qUxZ)Wh", $opt);

        //Requête pour récuper le tarif spécifique dans la bdd
        $checkTarif = "SELECT * FROM tarifer ";
        $checkResultTarif = $db->prepare($checkTarif);
        $checkResultTarif->execute();
        $prix = $checkResultTarif->fetchColumn();

        //Renvoie le tarif
        return $prix;
    } catch (PDOException $e) {
        echo "error";
        header('Location: ../../public/pages/login.php');
        die("Erreur de connexion : " . $e->getCode() . $e->getMessage());
    }
}

function getTarifById($id, $type, $periode)
{
    try {
        // Connexion à la base de données
        $dsn = "mysql:host=localhost;dbname=marieteam;charset=utf8";
        $opt = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        $db = new PDO($dsn, "supAdmin", "4uFw9is0/qUxZ)Wh", $opt);

        //Requête pour récuper le tarif spécifique dans la bdd
        $checkTarif = "SELECT tarif, id_type FROM tarifer WHERE id_liaison = ? AND  id_type = ? AND id_periode = ?";
        $checkResultTarif = $db->prepare($checkTarif);
        $checkResultTarif->bindParam(1, $id, PDO::PARAM_INT);
        $checkResultTarif->bindParam(2, $type, PDO::PARAM_INT);
        $checkResultTarif->bindParam(3, $periode, PDO::PARAM_INT);
        $checkResultTarif->execute();
        $prix = $checkResultTarif->fetchColumn();

        //Renvoie le tarif
        return $prix;
    } catch (PDOException $e) {
        echo "error";
        header('Location: ../../public/pages/login.php');
        die("Erreur de connexion : " . $e->getCode() . $e->getMessage());
    }
}

function getTarifByDate($date)
{
    try {
        // Connexion à la base de données
        $dsn = "mysql:host=localhost;dbname=marieteam;charset=utf8";
        $opt = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        $db = new PDO($dsn, "supAdmin", "4uFw9is0/qUxZ)Wh", $opt);

        //Requête pour récuper le tarif spécifique dans la bdd
        $checkTarif = "SELECT tarif, id_type FROM tarifer WHERE id_liaison = ? AND  id_type = ? AND id_periode = ?";
        $checkResultTarif = $db->prepare($checkTarif);
        $checkResultTarif->bindParam(1, $id, PDO::PARAM_INT);
        $checkResultTarif->bindParam(2, $type, PDO::PARAM_INT);
        $checkResultTarif->bindParam(3, $periode, PDO::PARAM_INT);
        $checkResultTarif->execute();
        $prix = $checkResultTarif->fetchColumn();

        //Renvoie le tarif
        return $prix;
    } catch (PDOException $e) {
        echo "error";
        header('Location: ../../public/pages/login.php');
        die("Erreur de connexion : " . $e->getCode() . $e->getMessage());
    }
}
