<?php

//Augmentation du temps d'exécution
ini_set('max_execution_time', '0');

//ajout configuration
include 'connexion.php';

header('Content-Type: text/html; charset=utf-8');

//ajout et ouverture du fichier
$csvfile = 'tickets_appels_201202.csv';

$openit = fopen($csvfile, 'r');

$row = array();

//lecture du fichier
$i = 0;
while (($data = fgetcsv($openit, 1000, ";")) !== FALSE) {
    
    //var_dump($data);
    

    if ($i != 0) {

        $comptefacture = $data[0];
        $numerofact = $data[1]; 
        $numeroabonne = $data[2];
        $date = $data[3];
        $heure = $data[4];
        $dureevolumereel = $data[5]; 
        $dureevolumefacture = $data[6]; 
        $type = $data[7];

        $prevQuery = "SELECT id FROM tickets_appels WHERE heure = '".$data[4]."'";
        $prevResult = $db->query($prevQuery);

        //Update - Insertion de données
        if($prevResult->num_rows > 0){
            $db->query("UPDATE tickets_appels SET compte_facture = '".$comptefacture."', numero_facture = '".$numerofact."', numero_abonne = '".$numeroabonne."', date = '".$date."', duree_volumereel = '".$dureevolumereel."', duree_volumefacture = '".$dureevolumefacture."', type = '".$type."' WHERE heure = '".$heure."'");
        } else {

            $requetesql = "INSERT INTO tickets_appels (compte_facture, numero_facture, numero_abonne, date, heure, duree_volumereel, duree_volumefacture, type) VALUES ('$comptefacture', '$numerofact', '$numeroabonne', '$date', '$heure', '$dureevolumereel', '$dureevolumefacture', '$type')";
            if ($db->query($requetesql)) {
                echo 'Requête parfaitement exécutée';
            }  else {
                echo 'Erreur sur la requête';
            }

        }

        
    }
    $i++;

}

fclose($csvfile);


?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Import Opération</title-->

        <!-- Librairies - Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Librairies - Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>

    <div class="text-right">
        <a href="index.php" class="btn btn-info" ><i class="fa fa-arrow-left"></i> Retour à la page principale</a>
    </div>


        <!-- Librairies - Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
</html>