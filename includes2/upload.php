
<?php
$compter=0; do {	
			$dossier = 'upload/';
			$fichier = basename($_FILES['fichier'.$compter]['name']);
			$taille_maxi = 3000000000;
			$taille = filesize($_FILES['fichier'.$compter]['tmp_name']);
			$extensions = array('.png', '.gif', '.jpg', '.jpeg', '.pdf');
			$extension = strrchr($_FILES['fichier'.$compter]['name'], '.');
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
			if(move_uploaded_file($_FILES['fichier'.$compter]['tmp_name'], $dossier . $fichier)) //correct si la fonction renvoie TRUE
			{
				$message = 'Upload effectué avec succès !';
				$chemin = $dossier . $fichier; 

				if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
				   
					  $insertSQL = sprintf("INSERT INTO fichiers (nomFichier, url, display, commissions_commission_id) VALUES (%s, %s, %s, %s)",
										   GetSQLValueString($fichier, "text"),
										   GetSQLValueString($chemin, "text"),
										   GetSQLValueString(1, "text"),
										   GetSQLValueString($_GET['comID'], "int"));
					
					  mysql_select_db($database_MyFileConnect, $MyFileConnect);
					  $Result1 = mysql_query($insertSQL, $MyFileConnect) or die(mysql_error());		  
					  
					}
				}
			}
			$compter++;
			} while ($compter < $_POST['compteur']);
?>