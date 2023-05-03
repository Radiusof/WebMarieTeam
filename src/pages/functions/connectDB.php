<?php
require '../../../vendor/autoload.php';

use Dotenv\Dotenv;

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
} catch (PDOException $e) {
    echo "error";
    $_SESSION["erreurMessageResa"] = "La connexion à la base de donnée n'est pas établie : " . $e->getCode() . $e->getMessage();
    $_SESSION["eerreurTypeResa"] = 1;

    die("Erreur de connexion : " . $e->getCode() . $e->getMessage());
}
