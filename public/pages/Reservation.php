<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>MarieTeam</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <?php include('../../src/inc/common/head_link.php') ?>
</head>

<body>
    <?php include('../../src/inc/common/header_alt.php') ?>
    <?php include_once('../../src/inc/common/meteoAPI.php') ?>


    <section class="position-relative py-4 py-xl-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2>Réservation</h2>
                    <p class="w-lg-50">Quelle sera votre prochaine destination ?</p>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2>Météo en direct de <?php echo $data->name; ?> </h2>
                    <div class="w-lg-50">
                        <img src="http://openweathermap.org/img/w/<?php echo $data->weather[0]->icon; ?>.png" class="weather-icon" />
                        <?php echo $data->main->temp_max; ?>°C --- <span class="min-temperature"><?php echo $data->main->temp_min; ?>°C</span>
                    </div>
                    <div class="w-lg-50">
                        <div>Humidité: <?php echo $data->main->humidity; ?> %</div>
                        <div>Vitesse du vent: <?php echo $data->wind->speed; ?> km/h</div>
                    </div>
                </div>
                <?php
                if (isset($_SESSION["date"]) && isset($_SESSION["secteur"]) && $_SESSION["date"] != "") {
                    $date = $_SESSION["date"];
                    $secteur = $_SESSION["secteur"];
                    $error_message_dispo =   $_SESSION["erreurMessageDispo"];
                    $error_type_dispo = $_SESSION["erreurTypeDispo"];

                    echo "Date selectionnée: " . $_SESSION["date"] . "<br>";
                }
                ?>
                <form class="border rounded-0" method="post">

                    <div><label class="mb-2" for="check-availability">Les réservations peuvent se faire jusqu'à 100 jours à l'avance.</label>
                        <div class="availability-input-wrapper">
                            <div><label class="d-block" for="selected-start-date">Jour de départ</label>
                                <input onchange="getDate(this.value)" id="selected-start-date" type="date" name="dateSelect" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime('+100 days')); ?> required">
                                <span id="resultDate"></span>
                            </div>

                        </div>
                        <div>
                            <div>
                                <label class="d-block"> Secteurs: </label>
                                <?php
                                include_once('../../src/pages/functions/getSecteurs.php');
                                getSecteurs();
                                ?>
                            </div>
                        </div>

                    </div>
                    <div id="resultLiaison"></div>

                    <div id="resultHoraires"></div>

                    <br>
                    <input id=" check-availability" class="btn btn-primary" type="submit" name="submitDispo" value="Vérifier !""></input>
                        <br>
                        <?php if (isset($_SESSION["erreurTypeDispo"]) && isset($_SESSION["erreurMessageDispo"])) {
                            echo '<span style="color:red;text-align:center;"><strong>' . $_SESSION["erreurMessageDispo"] . '</strong></span>';
                        }
                        ?>
                            </div>
                </form>


            </div>
            
        </div>
    </section>
    <script type=" text/javascript" src="../../public/pages/js/resaForm.js"></script>
                    <?php include('../../src/inc/common/footer.php') ?>
</body>


</html>