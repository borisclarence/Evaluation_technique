<?php

    /**
     * Configuration Base de données 
     * */

    $dbhost = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "appels";

    // Instanciation de la connexion
    $db = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);

    // check de la connexion
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

?>