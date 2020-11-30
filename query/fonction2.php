<?php
    session_start();

    include("connexion.php");
    $con->set_charset("utf8");
	require_once('php_image_magician.php');


    /* Start All Vehicle */
    function getAllVehicle(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT v.id,v.brand,v.model,v.color,v.numberplate,v.statut,c.latitude,c.longitude,v.creer,v.modifier,c.nom,c.prenom,c.phone,c.online
        FROM tj_vehicule v, tj_conducteur c
        WHERE v.id_conducteur=c.id AND v.statut='yes' AND c.longitude!='' AND c.latitude!=''";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }

        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }
    /* End All vehicle */

?>