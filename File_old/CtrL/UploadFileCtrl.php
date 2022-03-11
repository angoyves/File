<?php require_once('../Connections/MyFileConnect.php'); ?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$compter=1; do {	
			$dossier = '../upload/';
			$fichier = basename($_FILES['file'.$compter]['name']);
			$taille_maxi = 3000000000;
			$taille = filesize($_FILES['file'.$compter]['tmp_name']);
			$extensions = array('.png', '.gif', '.jpg', '.jpeg', '.pdf');
			$extension = strrchr($_FILES['file'.$compter]['name'], '.');
			//Début des vérifications de sécurité...
			if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
			{
				$erreur = $fichier.' : Vous devez uploader un fichier de type png, gif, jpg, jpeg, pdf...';
			}
			if($taille>$taille_maxi)
			{
				$erreur = 'Le fichier ' .$fichier. ' est trop gros...';
			}
			if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
			{
			//formatage du nom (suppression des accents, remplacements des espaces par "-")
			$fichier = strtr($fichier, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
			$fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
			if(move_uploaded_file($_FILES['file'.$compter]['tmp_name'], $dossier . $fichier)) //correct si la fonction renvoie TRUE
			{
				$message = 'Upload effectué avec succès !';
				$chemin = $dossier . $fichier; 

				if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frm_pubPm_insert")) {
				   
					  $insertSQL = sprintf("INSERT INTO fichiers (nomFichier, url, display, commissions_commission_id) VALUES (%s, %s, %s, %s)",
										   GetSQLValueString($fichier, "text"),
										   GetSQLValueString($chemin, "text"),
										   GetSQLValueString(1, "text"),
										   GetSQLValueString($_POST['comID'], "int"));
					
					  mysql_select_db($database_MyFileConnect, $MyFileConnect);
					  $Result1 = mysql_query($insertSQL, $MyFileConnect) or die(mysql_error());	
					  /*echo "<script type='".text/javascript."'>
						window.opener.location.reload(); 
						self.close(); 
						</script>";*/
					  $updateGoTo = "../index.php";
					   if (isset($_SERVER['QUERY_STRING'])) {
						//$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
						$updateGoTo .= $_SERVER['QUERY_STRING'];
					  }
					  header(sprintf("Location: %s", $updateGoTo));
					  
					}
				}
			}
			$compter++;
			} while ($compter <= $_POST['compteur']);

?>