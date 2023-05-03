<?php
require '../../vendor/autoload.php';

use Dotenv\Dotenv;

function getSecteurs()
{
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
