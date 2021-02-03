<?php 
    //ajout configuration
    include 'connexion.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Tickets Appels</title>

        <!-- Librairies - Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Librairies - Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
        
        <div class="container">
            <h2>Détails des appels</h2>

            <div class="row">

                <div class="col-md-12 head">
                    <div class="text-right">
                        <a href="index.php" class="btn btn-info" ><i class="fa fa-plus"></i> Rechargez la page</a>
                    </div>
                    <div class="text-left">
                        <a href="importdata.php" class="btn btn-info" ><i class="fa fa-plus"></i> Import</a>
                    </div>
                </div>

                <table class="table table-striped table-bordered">
                    <thead class="theark-dark">
                        <tr>
                            <th>N°</th>
                            <th>Compte Facturé</th>
                            <th>N° Facture</th>
                            <th>N° Abonné</th>
                            <th>Date</th>
                            <th>Heure</th>
                            <th>Durée/Volume réel</th>
                            <th>Durée/Volume facturé</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //Liste d'appels
                        $count = 0;
                        $result = $db->query("SELECT * FROM tickets_appels LIMIT 0,10");
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php  echo $row['compte_facture']; ?></td>
                                    <td><?php  echo $row['numero_facture']; ?></td>
                                    <td><?php  echo $row['numero_abonne']; ?></td>
                                    <td><?php  echo $row['date']; ?></td>
                                    <td><?php  echo $row['heure']; ?></td>
                                    <td><?php  echo $row['duree_volumereel']; ?></td>
                                    <td><?php  echo $row['duree_volumefacture']; ?></td>
                                    <td><?php  echo $row['type']; ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                                <tr>
                                    <td colspan="9">Aucun Résultats...</td>
                                </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                    <tfoot></tfoot>
                </table>
                <br>
                <table>
                     <?php
                        //La durée totale réelle des appels effectués après le 15/02/2012(inclus)
                        $result = $db->query("SELECT SUM(duree_volumereel) as duree_volumereel FROM `tickets_appels` WHERE date >= '15/02/2012'");
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php  echo ' Durée totale des appels'.$row['duree_volumereel']; ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                                <tr>
                                    <td colspan="9">Aucun Résultats...</td>
                                </tr>
                            <?php
                        }
                        ?>
                </table>
                 
                <br>

                <table>
                     <?php
                        // le TOP 10 des volumes data facturés en dehors de la tranche horaire 8h00-18h00, par abonné
                        $thiscount = 1;
                        $result = $db->query("SELECT duree_volumefacture FROM `tickets_appels` WHERE heure < '8h00' AND heure > '18h00' ORDER BY numero_abonne ASC LIMIT 0,10");
                        if ($result->num_rows > 0) {
                            echo 'Le top 10 des volumes de données de data facturé';
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php  echo $thiscount++.' '.$row['duree_volumefacture']; ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                                <tr>
                                    <td colspan="9">Aucun Résultats...</td>
                                </tr>
                            <?php
                        }
                        ?>
                </table>

                <br>
                
                <table>
                     <?php
                        //  la quantité totale de SMS envoyés par l'ensemble des abonnés
                        $result = $db->query("SELECT COUNT(id) as qte_sms FROM `tickets_appels` WHERE type = 'envoi de sms depuis le mobile'");
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php  echo 'La quantité de sms envoyés est:  '.$row['qte_sms']; ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                                <tr>
                                    <td colspan="9">Aucun Résultats...</td>
                                </tr>
                            <?php
                        }
                        ?>
                </table>

            </div>
        </div>

        <!-- Librairies - Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script> 
            function formToggle(ID) {
                var element = document.getElementById(ID);
                if (element.style.display === "none") {
                    element.style.display = "block";
                } else {
                    element.style.display = "none";
                }
            }
        </script>
    </body>
</html>