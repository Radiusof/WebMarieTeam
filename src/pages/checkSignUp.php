<?php
//Démarrer la session
session_start();

// Vérification de la soumission du formulaire
if (isset($_POST['submit'])) {
   // Récupération des valeurs du formulaire
   $nom = $_POST['name'];
   $_SESSION["nomClient"] = $nom;
   $prenom = $_POST['surname'];
   $_SESSION["prenomClient"] = $prenom;
   $adresse = $_POST['adresse'];
   $codePostal = $_POST['codePostal'];
   $ville = $_POST['ville'];
   $email = $_POST['email'];
   $_SESSION["emailClient"] = $email;
   $mdp = $_POST['mdp'];
   $_SESSION["mdpClient"] = $email;
   $mdp_rpt = $_POST['mdp-repeat'];
   $error_message_signUp = "";
   $_SESSION["erreurMessageSignUp"] = $error_message_signUp;
   $error_type_signUp = 0;
   $_SESSION["erreurTypeSignUp"] = $error_type_signUp;

   try {
      // Connexion à la base de données
      $dsn = "mysql:host=localhost;dbname=marieteam;charset=utf8";
      $opt = array(
         PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
      );
      $db = new PDO($dsn, "supAdmin", "4uFw9is0/qUxZ)Wh", $opt);

      //Vérifie le format email
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
         $_SESSION["erreurMessageSignUp"] = "Le format de l'email est invalide!";
         $_SESSION["erreurTypeSignUp"] = 0;
         header('Location: ../../public/pages/signUp.php');
         die();
      }
      //Vérifie si le mdp correspond
      if ($mdp != $mdp_rpt) {
         $_SESSION["erreurMessageSignUp"] = "Le mot de passe n'est pas identique à l'original!";
         $_SESSION["erreurTypeSignUp"] = 2;
         header('Location: ../../public/pages/signUp.php');
         die();
      }

      /*Régles de sécurité de mots de passe via Regex
         12 caractéres minimum
         Une majuscule minimum
         Une minuscule minimum
         Un nombre minimum
         Un caractére spécial minimum
         Lien : https://ihateregex.io/expr/password/
      */
      //'/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{12,}$/'
      if (strlen($mdp) <  12) {
         $_SESSION["erreurMessageSignUp"] = "Le mot de passe doit posseder au moins 12 caractéres au total! !";
         $_SESSION["erreurTypeSignUp"] = 2;
         header('Location: ../../public/pages/signUp.php');
         die();
      } else if (!preg_match('/[A-Z]/', $mdp)) {
         $_SESSION["erreurMessageSignUp"] = "Le mot de passe doit posseder au moins une majuscule !";
         $_SESSION["erreurTypeSignUp"] = 2;
         header('Location: ../../public/pages/signUp.php');
         die();
      } else if (!preg_match('/[a-z]/', $mdp)) {
         $_SESSION["erreurMessageSignUp"] = "Le mot de passe doit posseder au moins une minuscule !";
         $_SESSION["erreurTypeSignUp"] = 2;
         header('Location: ../../public/pages/signUp.php');
         die();
      } else if (!preg_match('/[0-9]/', $mdp)) {
         $_SESSION["erreurMessageSignUp"] = "Le mot de passe doit posseder au moins un nombre !";
         $_SESSION["erreurTypeSignUp"] = 2;
         header('Location: ../../public/pages/signUp.php');
         die();
      } else if (!preg_match('/[#?!@$ %^&*-]/', $mdp)) {
         $_SESSION["erreurMessageSignUp"] = "Le mot de passe doit posseder au moins un caractére spécial !";
         $_SESSION["erreurTypeSignUp"] = 2;
         header('Location: ../../public/pages/signUp.php');
         die();
      }

      // Vérifie si le code Postal est valide
      if (strlen($codePostal) < 5) {
         $_SESSION["erreurMessageSignUp"] = "Le code postal n'est pas au bon format!";
         $_SESSION["erreurTypeSignUp"] = 6;
         header('Location: ../../public/pages/signUp.php');
         die();
      }

      // Lance une première requête pour vérifier l'existence de l'adresse email dans la bdd
      $checkQuery = "SELECT * FROM utilisateur WHERE email = :email ";
      $checkResultQuery = $db->prepare($checkQuery);
      $checkResultQuery->bindParam('email', $email, PDO::PARAM_STR);

      //Vérifie si la requête à fonctionné
      if (!$checkResultQuery->execute()) {
         $_SESSION["erreurMessageSignUp"] = "Erreur lors de la requête.";
         $_SESSION["erreurTypeSignUp"] = 3;
         header('Location: ../../public/pages/signUp.php');
         die();
      }

      $enreg = $checkResultQuery->fetch(PDO::FETCH_OBJ);

      //Requete Insert
      $insertQuery = "INSERT INTO utilisateur (email, nom, prenom, adresse, ville, code_postal, password) 
      VALUES (?,?,?,?,?,?,?)";

      // Hache le mdp avant de l'inserer dans la bdd
      $secure_mdp = password_hash($mdp, PASSWORD_DEFAULT);

      // Exécution de la requête
      $checkResultInsert = $db->prepare($insertQuery);
      $checkResultInsert->bindParam(1, $email);
      $checkResultInsert->bindParam(2, $nom, PDO::PARAM_STR);
      $checkResultInsert->bindParam(3, $prenom, PDO::PARAM_STR);
      $checkResultInsert->bindParam(4, $adresse, PDO::PARAM_STR);
      $checkResultInsert->bindParam(5, $ville, PDO::PARAM_STR);
      $checkResultInsert->bindParam(6, $codePostal, PDO::PARAM_INT);
      $checkResultInsert->bindParam(7, $secure_mdp, PDO::PARAM_STR);

      //Verification si l'insert a bien été effectué.
      if (!$checkResultInsert->execute()) {
         $_SESSION["erreurMessageSignUp"] = "Erreur lors de l'ajout!";
         $_SESSION["erreurTypeSignUp"] = 5;
         header('Location: ../../public/pages/signUp.php');
         die();
      }

      //Renvoie vers la page d'accueil
      header('Location: ../../public/pages/index.php');
      die();
   } catch (PDOException $e) {
      switch ($e->getCode()) {
            //Erreur clé primare (Données déjà existante) 
         case 23000:

            $_SESSION["erreurMessageSignUp"] = "Votre adresse email est déja enregistré sur notre base de données!";
            $_SESSION["erreurTypeSignUp"] = 4;
            header('Location: ../../public/pages/signUp.php');
            die();

         default:
            $_SESSION["erreurMessageSignUp"] = "La connexion à la base de donnée n'est pas établie"  . $e->getCode() . $e->getMessage();
            $_SESSION["erreurTypeSignUp"] = 1;
            header('Location: ../../public/pages/signUp.php');
            die("Erreur de connexion : " . $e->getCode() . $e->getMessage());
      }
   }
}
