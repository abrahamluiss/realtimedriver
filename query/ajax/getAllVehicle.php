<?php 
	include('../fonction2.php');
    function getAllVehicle1(){
        $output[] = array();
        $output = getAllVehicle();
        echo json_encode($output);
    }
    if(isset($_POST['id'])){
        getAllVehicle1();
    }else{
		header('Location: 404erreur.php'); 
    }
?>