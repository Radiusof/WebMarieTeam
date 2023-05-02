<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>MarieTeam</title>
    <style>
        table,
        thead,
        tbody,
        tr,
        th,
        td {
            border: 1px solid black;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th {
            background: grey;
            border: 1px solid white;
            padding: 0;

        }
    </style>
    <?php include('../../src/inc/common/head_link.php') ?>
</head>

<body>
    <?php include('../../src/inc/common/header_alt.php') ?>
    <div class="container py-4 py-xl-5">
        <div class="row gy-4 gy-md-0">
            <div class="col-md-6" style="padding-left: 0px;">
                <div class="p-xl-5 m-xl-5" style="padding-top: 70px;padding-right: 46px;margin-right: 50px;margin-bottom: 44px;">
                    <?php
                    switch ($_SESSION['idBateau']) {
                        case 11:
                            echo "<img class=\"rounded img-fluid w-100 fit-cover\" style=\"min-height: 300px;padding-bottom: 0px;\" src=\"./img/Boat11.jpg\" width=\"354\" height=\"300\">";
                            echo  "<span class=\"legend\">Votre bateau : <bold>Le Luce Isle <bold></span>";
                            echo  "<span class=\"legend\">Votre traversee : <bold>" . $_SESSION['traversee']  . "<bold></span>";
                            break;
                        case 2:
                            echo "<img class=\"rounded img-fluid w-100 fit-cover\" style=\"min-height: 300px;padding-bottom: 0px;\" src=\"./img/Boat2.jpg\" width=\"354\" height=\"300\">";
                            echo  "<span class=\"legend\">Votre bateau : <bold>Le Al'Xi <bold></span>";
                            echo  "<span class=\"legend\">Votre traversee : <bold>" . $_SESSION['traversee']  . "<bold></span>";
                            break;
                        case 45:
                            echo "<img class=\"rounded img-fluid w-100 fit-cover\" style=\"min-height: 300px;padding-bottom: 0px;\" src=\"./img/Boat45.jpg\" width=\"354\" height=\"300\">";
                            echo  "<span class=\"legend\">Votre bateau : <bold>Le Shuwawa <bold></span>";
                            echo  "<span class=\"legend\">Votre traversee : <bold>" . $_SESSION['traversee']  . "<bold></span>";

                            break;
                        case 23:
                            echo "<img class=\"rounded img-fluid w-100 fit-cover\" style=\"min-height: 300px;padding-bottom: 0px;\" src=\"./img/Boat23.jpg\" width=\"354\" height=\"300\">";
                            echo  "<span class=\"legend\">Votre bateau : <bold>Le Queen Mama <bold></span>";
                            echo  "<span class=\"legend\">Votre traversee : <bold>" . $_SESSION['traversee']  . "<bold></span>";
                            break;
                        default:
                            echo "";
                    } ?>
                </div>
            </div>
            <div class="col-md-6 d-md-flex align-items-md-center">
                <div style="max-width: 350px;">
                    <h5 class="text-uppercase fw-bold">Veuillez sélectionné le nombre de personnes pour votre trajet : <br>
                        <bold> <?php echo $_SESSION['nomLiaisons'] ?></bold>
                    </h5>

                    <table id="placeLiaisons">
                        <thead>
                            <tr>
                                <th rowspan="2">Secteur</th>
                                <th rowspan="2">Liaisons</th>
                                <th rowspan="2">Date</th>
                                <th rowspan="2">Heure de départ</th>
                                <th colspan="3">Places Disponibles</th>
                            </tr>
                            <tr>
                                <th>A - Passager</th>
                                <th>B - Veh.inf.2m</th>
                                <th>C - Veh.sup.2m</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $_SESSION['secteur']; ?></td>
                                <td><?php echo $_SESSION['nomLiaisons']; ?></td>
                                <td><?php echo $_SESSION['date']; ?></td>
                                <td><?php echo $_SESSION['heure']; ?></td>
                                <?php
                                $valeurs = $_SESSION['capaciteMax'];
                                foreach ($valeurs as $valeur) {
                                    echo '<td>' . $valeur . '</td>';
                                }
                                ?>
                            </tr>

                        </tbody>
                    </table>
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-6 ">
                            <div class="card mb-5">
                                <div class="card-body d-flex flex-column align-items-center">

                                    <form action="../../src/pages/checkReservation.php" class="text-center" method="post">
                                        <div class="mb-3"><input class="form-control" type="text" name="nomResa" placeholder="Nom" required></div>
                                        <div class="mb-3"><input class="form-control" type="text" name="adresseResa" placeholder="Adresse" required></div>
                                        <div class="mb-3"><input class="form-control" type="number" name="CPResa" placeholder="CP" required></div>
                                        <div class="mb-3"><input class="form-control" type="text" name="VilleResa" placeholder="Ville" required></div>

                                        <table id="tarifLiaisons">
                                            <thead>
                                                <tr>
                                                    <th>Catégorie</th>
                                                    <th>Tarif €</th>
                                                    <th>Quantité</th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $tarifs = $_SESSION['tarif'];
                                                $libelles_type = $_SESSION['libelle_type'];
                                                for ($i = 0; $i < count($libelles_type); $i++) {
                                                    echo "<tr>";
                                                    echo '<td>' . $libelles_type[$i] . '</td>';
                                                    echo '<td>' . $tarifs[$i] . " €" . '</td>';
                                                    echo '<td>' . "<input type=\"number\" name=\"nombreResa[$i]\" min=\"0\" max=\"10\" step=\"1\" value=0>" . '</td>';
                                                    echo '<td><input type="hidden" name="tarifResa[' . $i . ']" value="' . $tarifs[$i] . '"> </td>';
                                                    echo '<td><input type="hidden" name="libelleResa[' . $i . ']" value="' . $libelles_type[$i] . '"> </td>';
                                                    echo "</tr>";
                                                }
                                                ?>

                                            </tbody>

                                        </table>
                                        <div class="mb-3"><input class="btn btn-primary d-block w-100" type="submit" name="submitResa" value="Confirmer la réservation"></input></div>

                                        <?php
                                        if (isset($_SESSION["erreurTypeResa"]) && isset($_SESSION["erreurMessageResa"])) {
                                            echo '<span style="color:red;text-align:center;"><strong>' . $_SESSION["erreurMessageResa"] . '</strong></span>';
                                        }
                                        ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include('../../src/inc/common/footer.php') ?>

</html>