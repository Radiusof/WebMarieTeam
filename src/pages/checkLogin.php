<?php
//Démarrer la session
session_start();
require '../../vendor/autoload.php';

use Dotenv\Dotenv;

$error_type_login = $error_message_login = "";
// Vérification de la soumission du formulaire
if (isset($_POST['submit'])) {
    // Récupération des valeurs du formulaire
    $email = $_POST['email'];
    $_SESSION["emailClient"] = $email;
    $mdp = $_POST['mdp'];
    $_SESSION["mdpClient"] = $email;
    $error_message_signUp = "";
    $_SESSION["erreurMessageLogin"] = $error_message_login;
    $error_type_signUp = 0;
    $_SESSION["erreurTypeLogin"] = $error_type_login;
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

        //Vérifie le format email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION["erreurMessageLogin"] = "Le format de l'email est invalide!";
            $_SESSION["erreurTypeLogin"] = 0;

            header('Location: ../../public/pages/login.php');
            die();
        }

        //Requête pour récuper le hash du mdp dans la bdd
        $checkMdp = "SELECT password FROM utilisateur WHERE email = ? ";
        $checkResultMdp = $db->prepare($checkMdp);
        $checkResultMdp->bindParam(1, $email, PDO::PARAM_STR);
        echo "check query";
        if (!$checkResultMdp->execute()) {
            $_SESSION["erreurMessageLogin"] = "Erreur lors de la requête.";
            $_SESSION["erreurTypeLogin"] = 1;

            header('Location: ../../public/pages/login.php');
            die();
        }
        if ($checkResultMdp->rowCount() == 0) {
            $_SESSION["erreurMessageLogin"] = "L'adresse email renseigné n'existe pas, veuillez réesssayer ou créer un compte.";
            $_SESSION["erreurTypeLogin"] = 2;

            header('Location: ../../public/pages/login.php');
            die();
        }

        $hashMdp = $checkResultMdp->fetchColumn();

        //Vérifie si le mdp correspond  à celle de la bdd

        if (!password_verify($mdp, $hashMdp)) {
            $_SESSION["erreurMessageLogin"] = "Mot de passe incorrect!";
            $_SESSION["erreurTypeLogin"] = 3;

            header('Location: ../../public/pages/login.php');
            die();
        }
        //Si ok, recupere le nom utilisateur pour la sauvegarder sur la session
        $checkNom = "SELECT prenom,id_utilisateur FROM utilisateur WHERE email = ? ";
        $checkResultNom = $db->prepare($checkNom);
        $checkResultNom->bindParam(1, $email, PDO::PARAM_STR);
        echo "check nom";
        if (!$checkResultNom->execute()) {
            $_SESSION["erreurMessageLogin"] = "Erreur lors de la requête.";
            $_SESSION["erreurTypeLogin"] = TRUE;

            header('Location: ../../public/pages/login.php');
            die();
        }

        //Renvoie vers la page d'accueil
        $result = $checkResultNom->fetch();
        $_SESSION["nomUser"] = $result['prenom'];
        $_SESSION['idUser'] = $result['id_utilisateur'];
        $_SESSION["loggedIn"] = true;

        header('Location: ../../public/pages/index.php');
        die();
    } catch (PDOException $e) {
        echo "error";
        $_SESSION["erreurMessageLogin"] = "La connexion à la base de donnée n'est pas établie"  . $e->getCode() . $e->getMessage();
        $_SESSION["erreurTypeLogin"] = 1;

        header('Location: ../../public/pages/login.php');
        die("Erreur de connexion : " . $e->getCode() . $e->getMessage());
    }
}
