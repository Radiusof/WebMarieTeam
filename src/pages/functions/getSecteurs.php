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
        echo "<select name='secteur' onchange='getLiaisons(this.value)'>";
        while ($row = $checkResultSecteurs->fetch()) {
            echo "<option value='" . $row['id_secteur'] . "'>" . $row['libelle_secteur'] . "</option>";
        }
        echo "</select>" . "<br>";
    } catch (PDOException $e) {

        die("Erreur de connexion : " . $e->getCode() . $e->getMessage());
    }
}
