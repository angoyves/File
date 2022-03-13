<?php
require('mysql_table.php');
require('../Connections/MyFileConnect.php');


require('../includes/myFileDB.php');
	
	if (isset($_POST['bizRegNo'])) {
	  $bizRegNo = $_POST['bizRegNo'];
	}

	echo $commissionLib = myFileDB::getInstance()->getLibById(commissions, commission_lib, commision_id, $bizRegNo);
	echo $commissionLib2 = myFileDB::getInstance()->getCommissionLibById($_POST['bizRegNo']);
	
	
//$colname = $_REQUEST['bizRegNo'];
// Connexion ?la base
$link = mysqli_connect('localhost:3301','root','','fichier_db');


?>