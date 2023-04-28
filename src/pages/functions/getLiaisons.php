<?php

function getSecteurs()
{
    try {
        // Connexion à la base de données
        $dsn = "mysql:host=localhost;dbname=marieteam;charset=utf8";
        $opt = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        $db = new PDO($dsn, "supAdmin", "4uFw9is0/qUxZ)Wh", $opt);

        //Requête pour récuper les secteurs
        $checkSecteurs = "SELECT * FROM secteur";
        $checkResultSecteurs = $db->prepare($checkSecteurs);
        $checkResultSecteurs->execute();

        // Créer la liste déroulante
        echo "<select name='secteur'>";
        while ($row = $checkResultSecteurs->fetch()) {
            echo "<option value='" . $row['id_secteur'] . "'>" . $row['libelle_secteur'] . "</option>";
        }
        echo "</select>";
    } catch (PDOException $e) {
        echo "error";
        header('Location: ../../public/pages/login.php');
        die("Erreur de connexion : " . $e->getCode() . $e->getMessage());
    }
}

function getLiaisonsByDateAndSecteur($secteur, $date)
{
    try {
        // Connexion à la base de données
        $dsn = "mysql:host=localhost;dbname=marieteam;charset=utf8";
        $opt = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        $db = new PDO($dsn, "supAdmin", "4uFw9is0/qUxZ)Wh", $opt);

        //Requête pour récuper les liaisons disponibles a la période sélectionnée.
        $checkDispo = "SELECT * 
        FROM liaison 
        WHERE id_secteur = ? 
        AND id_liaison IN (
            SELECT id_liaison
            FROM tarifer 
            WHERE id_periode  IN ( 
                SELECT id_periode 
                FROM periode
                WHERE ? BETWEEN debut AND fin AND ? IN (
                    SELECT date_depart
                    FROM travers
                )
            )
        )";
        $checkResultDispo = $db->prepare($checkDispo);
        $checkResultDispo->bindParam(1, $secteur, PDO::PARAM_INT);
        $checkResultDispo->bindParam(2, $date, PDO::PARAM_STR);
        $checkResultDispo->bindParam(3, $date, PDO::PARAM_STR);

        if (!$checkResultDispo->execute()) {
            $_SESSION["erreurMessageDispo"] = "Erreur lors de la requête.";
            $_SESSION["erreurTypeDispo"] = 1;

            header('Location: ../../public/pages/index.php');
            die();
        }

        // Créer la liste déroulante
        echo "<select name='dispoliaison'>";
        while ($row = $checkResultDispo->fetch()) {
            echo "<option value='" . $row['id_liaison'] . "'>" . $row['port_depart'] . " - " . $row['port_arrivee'] . "</option>";
        }
        echo "</select>" . "<br>";

        //Requête pour récuper les liaisons disponibles a la période sélectionnée.
        $checkDate = "SELECT * 
        FROM liaison 
        WHERE id_secteur = ? 
        AND id_liaison IN (
            SELECT id_liaison
            FROM tarifer 
            WHERE id_periode  IN ( 
                SELECT id_periode 
                FROM periode
                WHERE ? BETWEEN debut AND fin AND ? IN (
                    SELECT date_depart
                    FROM travers
                )
            )
        )";
        $checkDateDispo = $db->prepare($checkDate);
        $checkDateDispo->bindParam(1, $secteur, PDO::PARAM_INT);
        $checkDateDispo->bindParam(2, $date, PDO::PARAM_STR);
        $checkDateDispo->bindParam(3, $date, PDO::PARAM_STR);

        if (!$checkDateDispo->execute()) {
            $_SESSION["erreurMessageDispo"] = "Erreur lors de la requête.";
            $_SESSION["erreurTypeDispo"] = 1;

            header('Location: ../../public/pages/index.php');
            die();
        }

        $count = count($checkDateDispo->fetchAll());
        if ($count == 0) {
            $_SESSION["erreurMessageDispo"] = "Pas de liaisons disponibles dans ce secteur à cette date.";
            $_SESSION["erreurTypeDispo"] = 5;

            header('Location: ../../public/pages/index.php');
            die();
        }
    } catch (PDOException $e) {
        echo "error";
        $_SESSION["erreurMessageDispo"] = "La connexion à la base de donnée n'est pas établie : " . $e->getCode() . $e->getMessage();
        $_SESSION["erreurTypeDispo"] = 1;

        header('Location: ../../public/pages/index.php');
        die("Erreur de connexion : " . $e->getCode() . $e->getMessage());
    }
}


function getIdLiaison()
{
    try {
        // Connexion à la base de données
        $dsn = "mysql:host=localhost;dbname=marieteam;charset=utf8";
        $opt = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        $db = new PDO($dsn, "supAdmin", "4uFw9is0/qUxZ)Wh", $opt);
    } catch (PDOException $e) {
        echo "error";
        $_SESSION["erreurMessageDispo"] = "La connexion à la base de donnée n'est pas établie : " . $e->getCode() . $e->getMessage();
        $_SESSION["erreurTypeDispo"] = 1;

        header('Location: ../../public/pages/index.php');
        die("Erreur de connexion : " . $e->getCode() . $e->getMessage());
    }
}
