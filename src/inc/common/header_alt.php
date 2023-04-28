<nav class="navbar navbar-light navbar-expand navigation-clean">
    <div class="container">
        <a class="navbar-brand text-start link-secondary" href="index.php">Compagnie Marie Team</a>
        <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"></button>
        <div class="collapse navbar-collapse" id="navcol-1">
            <?php session_start();
            date_default_timezone_set("Europe/Paris");
            if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
                echo "<a class=\"btn ms-auto\" role=\"button\"  style=\"margin-left: 51px;color: transparent; background_color: transparent\"></a>";
                echo "<p style=\"margin-bottom: -2px;\"><strong>Bienvenue " . $_SESSION["nomUser"] . "</strong></p>";
                echo "<a class=\"btn btn-primary text-end d-xl-flex mb-auto\" role=\"button\" style=\"margin-left: 48px;display: flex;position: relative;margin-top: -1px;padding-left: 9px;\" data-bs-target=\"#login\" href=\"../../src/pages/logout.php\">Se déconnecter</a>";
            } else {
                echo "<a class=\"btn btn-primary ms-auto\" role=\"button\" href=\"login.php\" style=\"margin-left: 51px;\">Identification</a>";
                echo "<a class=\"btn btn-primary text-end d-xl-flex mb-auto\" role=\"button\" style=\"margin-left: 48px;display: flex;position: relative;margin-top: -1px;padding-left: 9px;\" data-bs-target=\"#login\" href=\"signUp.php\">Inscription</a>";
            } ?>
        </div>
    </div>
</nav>