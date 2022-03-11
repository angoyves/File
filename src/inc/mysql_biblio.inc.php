<?php
/*************************************
*  Connexion / d?onnexion ?la bdd  *
**************************************/
function connect_2_db(){
	//Initialisation des vars de connexion
	global $MyFileConnect;
	//********** Vous pouvez modifier les valeurs ci-dessous afin de s?uriser la base /* /*************************/
	$host = "localhost";
	$db   = "fichier_db8";
	$usr  = "root";
	$pass = "";
		//********** Vous pouvez modifier les valeurs ci-dessous afin de s?uriser la base *************************
	/* $host = "sql7"; // "169.254.240.164";
	$db   = "cawad";
	$usr  = "cawad";
	$pass  = "cwdbase"; */
//**************************************

//**************************************
	
	//*********************************************************************************************************************************
	//************************* Code ?ne surtout pas toucher, sinon pouvant destabiliser les ??ents du site ************************
	//*********************************************************************************************************************************	
	
	$MyFileConnect = mysql_pconnect($host,$usr,$pass) or die("Erreur de connexion ?la base de donn&eacute;es...<br>".mysql_error());
	mysql_select_db($db) or die ("Erreur lors de la selection de la base de donn&eacute;es ".mysql_error());
}
//***** Fin cha?e de connexion *****

//Lorskon a un enregistrement null, on retourne une valeur par d?aut pr??inie
function rewrite_record($record, $default){
	if($record == ""){
		$record = $default;
	}
	else $record = $record;
	return $record;
}
function rewrite_record2($recordOutput, $varTest, $valReturn){
	if($recordOutput == $varTest){
		$record = $valReturn;
	}
	return $record;
}
//Ex: rewrite_record2($row_rsSelEnreg['sex'], "M", "Masculin") 
//---> Retournera soit une chaine vide, soit la valeur "Masculin"
function rewrite_record3($recordOutput, $varTest, $valReturn){
	if($recordOutput == $varTest){
		$record = $valReturn;
	}
	else $record = $recordOutput;
	return $record;
}
//Ex: rewrite_record3($row_rsSelEnreg['sex'], "M", "Masculin") 
//---> Retournera soit une chaine correspondant ?notre rs, soit la valeur "Masculin"
//****************************************************************************/


//Alterner les couleurs pour un tableau dynamique
//Il faut tjrs initialiser puis ins?er un compteur avant d'entrer ds la boucle while, puis prendre la valeur de ce compteur
//pour placer comme 1er argument de notre fonction
function alter_color($cpt, $col1, $col2){
	$col = (($cpt%2)==0)?$col1:$col2;
	return $col;
}
//Se deconnecter apres execution des requetes......
function disconnect_2_db()
    {
	mysql_close();
    }
#***************** D?onnexion *********************


	
//******************************************* R E Q U E T E S ***********************************************

/*****************************************************
*  Compter le nombre d' enregistrement d'une table  *
******************************************************/
function count_in_tbl($tbl,$field){
	global $MyFileConnect;
	$select = "SELECT count($field) FROM $tbl";
	$result = mysql_query($select)  or die("Erreur de selection du nombre ".mysql_error());
	$row = mysql_fetch_row($result);
	$total = $row[0];
	//echo $total;
	return $total;
	mysql_free_result($result);
}
	
	//Comptage suivant un crit?e particulier
	function count_in_tbl_where($tbl,$field,$where){
	global $MyFileConnect;
	$select = "SELECT count($field) FROM $tbl WHERE $field='$where'";
	$result = mysql_query($select)  or die("Erreur de selection du nombre ".mysql_error());
	$row = mysql_fetch_row($result);
	$total = $row[0];
	//echo $total;
	return $total;
	//mysql_free_result($result);
    }
	
		//Comptage suivant deux crit?es particuliers
	function count_in_tbl_where2($tbl,$field,$where, $where2, $where2val)
    {
	global $MyFileConnect;
	$select = "SELECT count($field) FROM $tbl WHERE $field='$where' AND $where2='$where2val'";
	$result = mysql_query($select)  or die("Erreur de selection du nombre ".mysql_error());
	$row = mysql_fetch_row($result);
	$total = $row[0];
	//echo $total;
	return $total;
	//mysql_free_result($result);
    }
//***** Fin comptage nb enregistrements *****


/**************************************************************************
*  Affiche l'enregistrement le plus r?ent d'une table suivant un crit?e *
****************************************************************************/
	//Ex: ligne 102 dans actu.php de demain le cameroun => Affiche les articles les plus r?ents
	//Voir le debut du bloc pour affichage du resultat de la requ?e sur 2 ou n colonnes
	function show_last_where($tbl, $field, $where_field, $where_value){
		global $MyFileConnect;
		$query = "SELECT `$field` FROM $tbl WHERE `$where_field` = '$where_value'";
		$result = mysql_query($query, $MyFileConnect)  or die("Erreur de selection <br />".mysql_error());
		if($total = mysql_num_rows($result)){
			while ($row = mysql_fetch_object($result)){
				$res = $row->$field;
			}
		}
		else{
			$res = 0;
		}
		return $res;
	}
		
//A utiliser de pr?erence
function show_last_where_ordered($tbl, $field, $where_field, $where_value, $order_field){
		global $MyFileConnect;
		$query = "SELECT `$field` FROM $tbl WHERE `$where_field` = '$where_value' AND `display` = '1' ORDER BY $order_field ASC";
		$result = mysql_query($query, $MyFileConnect)  or die("Erreur de selection <br />".mysql_error());
		if($total = mysql_num_rows($result)){
			while ($row = mysql_fetch_object($result)){
				$res = $row->$field;
			}
		}
		else{
			$res = 0;
		}
		return $res;
	}
//***** Fin affichage dernier enregistrement *****

/*************************************************************
*  Tester si une entr? existe d??dans la base de donn?s  *   header("main.php?user=$_POST[login]")
**************************************************************/
function chk_entry($tbl, $field, $entry)  //$tbl = latable a indexer, $field = le champ concern? $entry = la valeur ?tester prise ds le formulaire
	{
	global $MyFileConnect;
	$query = "SELECT * FROM `$tbl` WHERE `$field` = '$entry'";
	$result = mysql_query($query, $MyFileConnect) or die ("Erreur d'extraction des donn?s dans la base ".mysql_error());
	$row = mysql_fetch_row($result);
	if($total = $row[0])  //Mysql ?g???au moins 1 resultat 
		return true;
	}
	
function chk_2entries($tbl, $field1, $field2, $entry1, $entry2)  //$tbl = latable a indexer, $field = le champ concern? $entry = la valeur ?tester prise ds le formulaire
	{
	global $MyFileConnect;
	$query = "SELECT * FROM `$tbl` WHERE `$field1`= '$entry1' AND `$field2`= '$entry2'";
	$result = mysql_query($query, $MyFileConnect) or die ("Erreur d'extr= '$entry'action des donn?s dans la base ".mysql_error());
	$row = mysql_fetch_row($result);
	if($total = $row[0])  //Mysql ?g???au moins 1 resultat 
		return true;
	}

// **** Fin de test de l'existance de l'entr? utilisateur dans la BDD *****



/**************************************************************************
*  Tester si une entr? particuli?e existe d??dans la base de donn?s  *   header("main.php?user=$_POST[login]")
***************************************************************************/
function chk_entry_1($tbl, $field, $entry, $fieldtest, $entrytest)  //$tbl = latable a indexer, $field = le champ concern? $val est la valeur fixe ?comparer, $entry = la valeur ?tester prise ds le formulaire
	{
		// chk la valeur(entrytest) du champ display(fieldtest) de l'user 
	global $MyFileConnect;
	$query = "SELECT * FROM $tbl WHERE $field = '$entry' and $fieldtest = '$entrytest'";
	$result = mysql_query($query, $MyFileConnect) or die ("Erreur d'extraction des donn?s de la base ".mysql_error());
	$row = mysql_fetch_row($result);
	if($total = $row[0])  //Mysql ?g???au moins 1 resultat 
	return true;
	}
// **** Fin de test de l'existance de l'entr? utilisateur dans la BDD *****


/*************************************************************
*  Tester le couple usr / pass dans la base de donn?s  *   
**************************************************************/
#Non crypt?[d?onseill?
function chk_usr_pass($tbl, $usr_field, $pass_field, $usr_entry, $pass_entry)  //$tbl = latable a indexer, $field = le champ concern? $entry = la valeur ?tester prise ds le formulaire
	{
	global $MyFileConnect;
	global $query;
	$query = "SELECT $usr_field, $pass_field FROM $tbl WHERE $usr_field = '$usr_entry' AND $pass_field = '$pass_entry'";
	$result = mysql_query($query, $MyFileConnect) or die ("Erreur d'extraction des donn?s dans la base ".mysql_error());
	$row = mysql_fetch_row($result);
	if($total = $row[0])  //Mysql ?g???au moins 1 resultat 
		return true;
	}
	
#Crypt?
function chk_usr_pass_enc($tbl, $usr_field, $pass_field, $usr_entry, $pass_entry)  //$tbl = latable a indexer, $field = le champ concern? $entry = la valeur ?tester prise ds le formulaire
	{
	global $MyFileConnect, $query;
	$pass_entry = md5($pass_entry);
	$query = "SELECT $usr_field, $pass_field FROM $tbl WHERE $usr_field = '$usr_entry' AND $pass_field = '$pass_entry'";
	$result = mysql_query($query, $MyFileConnect) or die ("Erreur d'extraction des donn?s dans la base ".mysql_error());
	$row = mysql_fetch_row($result);
	if($total = $row[0])  //Mysql ?g???au moins 1 resultat 
		return true;
	}

// **** Fin de test du couple usr / pass dans la BDD *****

/*************************************************************
*  Tester le couple usr / pass / Status dans la base de donn?s  *   
**************************************************************/
#NB: les labels pour les status dans ce cas ci son output? par l'interm?iaire d'un combobox
#L'utilisateur, en se connectant, choisit le status auquel il appartient, puis se connecte

#Non crypt?[d?onseill?
function chk_usr_pass_status($tbl, $usr_fld, $pass_fld, $status_fld, $usr_entry, $pass_entry, $status_value){  //$tbl = latable a indexer, $field = le champ concern? $entry = la valeur ?tester prise ds le formulaire
	global $MyFileConnect, $query;
	$query = "SELECT * FROM $tbl WHERE $usr_fld = '$usr_entry' AND $pass_fld = '$pass_entry' AND $status_fld = '$status_value'";
	$result = mysql_query($query, $MyFileConnect) or die ("Erreur d'extraction des donn?s dans la base ".mysql_error());
	$row = mysql_fetch_row($result);
	if($total = $row[0])  //Mysql ?g???au moins 1 resultat 
	return true;
}
	
#Crypt?
function chk_usr_pass_status_enc($tbl, $usr_field, $pass_field, $status_field, $usr_entry, $pass_entry, $status_value)  //$tbl = latable a indexer, $field = le champ concern? $entry = la valeur ?tester prise ds le formulaire
	{
	global $MyFileConnect, $query;
	$pass_entry = md5($pass_entry);
	$query = "SELECT $usr_field, $pass_field FROM $tbl WHERE $usr_field = '$usr_entry' AND $pass_field = '$pass_entry' AND $status_field = '$status_value'";
	$result = mysql_query($query, $MyFileConnect) or die ("Erreur d'extraction des donn?s dans la base ".mysql_error());
	$row = mysql_fetch_row($result);
	if($total = $row[0])  //Mysql ?g???au moins 1 resultat 
		return true;
	}
	
	
function chk_usr_pass_status_enc2($tbl, $usr_field, $pass_field, $status_field, $usr_entry, $pass_entry, $status_value, $where_field, $where_val)  //$tbl = latable a indexer, $field = le champ concern? $entry = la valeur ?tester prise ds le formulaire
	{
	global $MyFileConnect, $query;
	$pass_entry = md5($pass_entry);
	$query = "SELECT $usr_field, $pass_field FROM $tbl WHERE $usr_field = '$usr_entry' AND $pass_field = '$pass_entry' AND $status_field = '$status_value' AND $where_field = '$where_val'";
	$result = mysql_query($query, $MyFileConnect) or die ("Erreur d'extraction des donn?s dans la base ".mysql_error());
	$row = mysql_fetch_row($result);
	if($total = $row[0])  //Mysql ?g???au moins 1 resultat 
		return true;
	}


// **** Fin de test du trio usr / pass / Status dans la BDD *****



/*****************************************
     Ajouter un utilisateur ds la BDD
******************************************/
function adduser($login,$pass,$tbl)
    {
	global $MyFileConnect;
	$result = mysql_query("INSERT INTO $tbl (login, password) VALUES ($login, $password)", $MyFileConnect);
	return mysql_insert_id($MyFileConnect);
    }
//*********** Fin d'ajout d'utilisateur ****************
	//Connecter ou deconnecter un user
	function set_connected($table, $field, $login_field, $user_entry, $val){
		 //$val est un booleen qui indique si l'on est connect?ou pas
		global $MyFileConnect;
		$query = "UPDATE $table SET $field = '$val' WHERE $login_field = '$user_entry'";
		$result = mysql_query($query,$MyFileConnect) or die("Erreur de mise ?jour de champ <br>".mysql_error());
	}


	function add_entry5($table,$field1,$field2,$field3,$field4,$field5,$entry1,$entry2,$entry3,$entry4,$entry5){
		global $MyFileConnect;
		$query = "INSERT INTO $table($field1,$field2,$field3,$field4,$field5) VALUES('$entry1','$entry2','$entry3','$entry4','$entry5')";
		$result = mysql_query($query,$MyFileConnect) or die("Erreur d'ajout d'enregistrement:<br>".mysql_error());
		$total = mysql_affected_rows($MyFileConnect);
		if($total>=1){
			/*print "<script>alert('Entr? ajout? avec succ?')</script>";*/
			return true;
		}
		else{
			return false;
		}
	}
	
	
		function add_guestbook($gbtable, $field1, $field2, $field3, $field4, $field5, $field6, $entry1, $entry2, $entry3, $entry4, $entry5, $entry6){
		global $MyFileConnect;
		$query = "INSERT INTO $gbtable($field1,$field2,$field3,$field4,$field5) VALUES('$entry1','$entry2','$entry3','$entry4','$entry5')";
		$result = mysql_query($query,$MyFileConnect) or die("Erreur d'ajout d'enregistrement:<br>".mysql_error());
		$total = mysql_affected_rows($MyFileConnect);
		if($total>=1){
			/*print "<script>alert('Entr? ajout? avec succ?')</script>";*/
			return true;
		}
		else{
			return false;
		}
	}


// ***

	
// *** Supprimer un enregistrement ds un champ $field sp?ifi?de la bdd ***
	function rem_entry($table, $field_where, $entry){
		global $MyFileConnect;
		$query = "DELETE FROM $table WHERE `$field_where` = '$entry'";
		$result = mysql_query($query, $MyFileConnect) or die("Erreur de retrait d'une entr&eacute;e dans la bdd <br>".mysql_error());
	}
// *** Fin Suppression de l'enregistrement
	
	
// * Charger les valeurs d'un champ $field ds un combobox***
	function combo_sel_row($table,$field){
	/*$table = la table de la bdd
	  $field = champ de la bdd concern?
	  $val = la valeur ?inserer ds les options, ki seront r?up??s*/
		global $MyFileConnect;
		$query = "SELECT $field FROM $table";
		$result = mysql_query($query,$MyFileConnect) or die("Erreur de s&eacute;lection de donn&eacute;es ds la bdd <br>".mysql_error());
		if($total = mysql_num_rows($result)){
			while($row = mysql_fetch_object($result)){
				$val = $row->$field;
				print "<option>$val</option>\n";
			}
		}
	}
// *** Fin chargement combo
	
// * Charger les valeurs d'un champ $field ds un combobox***
	function combo_sel_row_2($table, $field_id, $field_val){
	/*$table = la table de la bdd
	  $field = champ de la bdd concern?
	  $val = la valeur ?inserer ds les options, ki seront r?up??s*/
		global $MyFileConnect;
		$query = "SELECT $field_id, $field_val FROM $table ORDER BY $field_val";
		$result = mysql_query($query, $MyFileConnect) or die("Erreur de s&eacute;lection de donn&eacute;es ds la bdd <br>".mysql_error());
		if($total = mysql_num_rows($result)){
			while($row = mysql_fetch_object($result)){
				$id = $row->$field_id;
				$val = $row->$field_val;
				print "<option value=\"$id\">".chapo($val, 30)."</option>\n";
			}
		}
	}
// *** Fin chargement combo


// * Charger les valeurs d'un champ $field ds un combobox condition?par une valeur $valwhere du champ $wherefield***
	function combo_sel_row_where($table, $field_id, $field_val, $where_field, $where_val){
	/*$table = la table de la bdd
	  $field = champ de la bdd concern?
	  $val = la valeur ?inserer ds les options, ki seront r?up??s*/
		global $MyFileConnect;
		$query = "SELECT $field_id, $field_val FROM $table WHERE $where_field = '$where_val' ORDER BY $field_val";
		$result = mysql_query($query, $MyFileConnect) or die("Erreur de s&eacute;lection de donn&eacute;es ds la bdd <br>".mysql_error());
		if($total = mysql_num_rows($result)){
			while($row = mysql_fetch_object($result)){
				$id = $row->$field_id;
				$val = $row->$field_val;
				print "<option value=\"$id\">$val</option>\n";
			}
		}
	}
	
	
	// * Charger les valeurs d'un champ $field ds un combobox condition?par une valeur $valwhere du champ $wherefield et rediriger automatiquement vers la page $page_redirect.... A utiliser avec le menu de reroutage de dreamweaver.***
	function redir_combo_sel_row_where($table, $field_id, $field_val, $where_field, $where_val, $page_redirect, $redir_key="query"){
	/*$table = la table de la bdd
	  $field = champ de la bdd concern?
	  $val = la valeur ?inserer ds les options, ki seront r?up??s*/
		global $MyFileConnect;
		$query = "SELECT $field_id, $field_val FROM $table WHERE $where_field = '$where_val' ORDER BY $field_val";
		$result = mysql_query($query, $MyFileConnect) or die("Erreur de s&eacute;lection de donn&eacute;es ds la bdd <br>".mysql_error());
		if($total = mysql_num_rows($result)){
			while($row = mysql_fetch_object($result)){
				$id = $row->$field_id;
				$val = chapo($row->$field_val, 50);
				print "<option value=\"$page_redirect?$redir_key=$id\">$val</option>\n";
			}
		}
	}
	
		function combo_sel_row_whereNot($table, $field_id, $field_val, $where_field, $where_val){
	/*$table = la table de la bdd
	  $field = champ de la bdd concern?
	  $val = la valeur ?inserer ds les options, ki seront r?up??s*/
		global $MyFileConnect;
		$query = "SELECT $field_id, $field_val FROM $table WHERE $where_field != '$where_val' ORDER BY $field_val";
		$result = mysql_query($query, $MyFileConnect) or die("Erreur de s&eacute;lection de donn&eacute;es ds la bdd <br>".mysql_error());
		if($total = mysql_num_rows($result)){
			while($row = mysql_fetch_object($result)){
				$id = $row->$field_id;
				$val = $row->$field_val;
				print "<option value=\"$id\">$val</option>\n";
			}
		}
	}

// *** Fin chargement combo conditionn?



// * Charger les valeurs d'un champ $field ds un combobox cette fois, manipulation des dates***
	function combo_sel_date_2($table, $field_id, $field_val){
	/*$table = la table de la bdd
	  $field = champ de la bdd concern?
	  $val = la valeur ?inserer ds les options, ki seront r?up??s*/
		global $MyFileConnect;
		$query = "SELECT $field_id, $field_val FROM $table ORDER BY $field_val";
		$result = mysql_query($query, $MyFileConnect) or die("Erreur de s&eacute;lection de donn&eacute;es ds la bdd <br>".mysql_error());
		if($total = mysql_num_rows($result)){
			while($row = mysql_fetch_object($result)){
				$id = $row->$field_id;
				$val = date_fr($row->$field_val);
				print "<option value=\"$id\">$val</option>\n";
			}
		}
	}
// *** Fin chargement combo

// * Charger les valeurs de deux champ $field1 et $field ds un combobox avec concat?ation ex: prenom nom pour Guy ZINGUI***
	function combo2_sel_row_2($table, $field_id, $field_val1, $field_val2){
	/*$table = la table de la bdd
	  $field = champ de la bdd concern?
	  $val = la valeur ?inserer ds les options, ki seront r?up??s*/
		global $MyFileConnect;
		$query = "SELECT * FROM $table ORDER BY $field_val1";
		$result = mysql_query($query, $MyFileConnect) or die("Erreur de s&eacute;lection de donn&eacute;es ds la bdd <br>".mysql_error());
		if($total = mysql_num_rows($result)){
			while($row = mysql_fetch_object($result)){
				$id = $row->$field_id;
				$val1 = $row->$field_val1;
				$val2 = $row->$field_val2;
				print "<option value=\"$id\">$val1 $val2</option>\n"; // Guy(prenom) ZINGUI(nom)
			}
		}
	}
	
	// * Charger les valeurs de deux champ $field1 et $field ds un combobox avec un where clause avec concat?ation ex: prenom nom pour Guy ZINGUI WHERE guy zingui = single usr***
	function combo2_sel_row_where2($table, $field_id, $field_val1, $field_val2, $where_field, $where_val){
	/*$table = la table de la bdd
	  $field = champ de la bdd concern?
	  $val = la valeur ?inserer ds les options, ki seront r?up??s*/
		global $link;
		$query = "SELECT $field_id, $field_val1, $field_val2 FROM $table WHERE $where_field = '$where_val' ORDER BY $field_val1";
		$result = mysql_query($query, $link) or die("Erreur de s&eacute;lection de donn&eacute;es ds la bdd <br>".mysql_error());
		if($total = mysql_num_rows($result)){
			while($row = mysql_fetch_object($result)){
				$id = $row->$field_id;
				$val1 = $row->$field_val1;
				$val2 = $row->$field_val2;
				print "<option value=\"$id\">$val1 $val2</option>\n"; // Guy(prenom) ZINGUI(nom)
			}
		}
	}
// *** Fin chargement combo
	
// * Supprimer une valeur d'un champ -> d'un enregistrement ds un combo***
	function del_combo_entry($table, $field, $selected){
		global $MyFileConnect;
		$query = "DELETE FROM $table WHERE $field = '$selected'";
		$result = mysql_query($query,$MyFileConnect) or die("Impossible de supprimer...<br>".mysql_error());
		if($result){
			print "<script>alert('Suppression de $selected effectu? avec succ?...')</script>";
		}
		else{
			print "<script>alert('Impossible de supprimer $selectted ...')</script>";
		
		}
		return (mysql_affected_rows($MyFileConnect));
	}
// *** Fin suppression d'enregistrement ?partir d'un champ
	

//* S?ectionner ts les enregistrements de la table $table index? par le champ $field
	function combo_get_row_indexed($table,$field,$index){
		global $MyFileConnect;
		$query = "SELECT * FROM $table WHERE $field = '$index'";
		$result = mysql_query($query) or die ("Erreur SQL! ".mysql_error());
		if($total = mysql_num_rows($result, $MyFileConnect)){
			while($row = mysql_fetch_array($result)){
				print "<option>".$row["$field"]."</option>";
			}
		}
		else{
			print "<option>Aucun</option>";
		}
	}
// ***	Fin combo_get_row_indexed


//Mise ?jour en cascade
// * Mettre le champ $field_to update de la table $table ?jour ?l'aide de la valeur $val_updated suivantla clause $where 
// * NB: On peut ajouter d'autres champ ?mettre ?jour
	function update_entry($table, $field_to_update, $val_updated, $where){
		$err_msg = "";
		$query = "UPDATE $table SET $field_to_update = '$val_updated' WHERE $field_to_update = '$where'";
		$result = mysql_query($query) or die("Erreur de mise ?jour".mysql_error());
		if($result){
			return true;
			$err_msg .= "Le Champ $field_to_update a ete mis ?jour";
		}
		else{
			return false;
		}
	}
	//Mettre ?jour un enregistrement unique
	function update_entry2($table, $field_to_update, $val_updated, $where_field, $where_value){
		$err_msg = "";
		$query = "UPDATE $table SET $field_to_update = '$val_updated' WHERE $where_field = '$where_value'";
		$result = mysql_query($query) or die("Erreur de mise ?jour".mysql_error());
		if($result){
			return true;
			//$err_msg .= "Le Champ $field_to_update a ete mis ?jour";
		}
		else{
			return false;
		}
	}
// *** Fin de la mise ?jour d'un enregistrement

// * Extraire l'id d'une table ?partir du nom d'un de ses champs
// * NB: Ici, on utilise une valeur comme pivot (WHERE CLAUSE) appartenant ?un champ
function get_id_tbl($tble,$field_id,$field_test,$usr_entry){ //ex: get_id_tbl("gpe","id_gpe","lib_gpe",$select_gpe) prend l'id_pe correspondant au lib_gpe choisi ds la table gpe
	global $MyFileConnect;
	$query = "SELECT $field_id FROM $tble WHERE $field_test = '$usr_entry'";
	$result = mysql_query($query,$MyFileConnect) or die("Erreur d'extraction <br>".mysql_error());
		if($total = mysql_num_rows($result)){
			while($row = mysql_fetch_object($result)){
				$returned_val = $row->$field_id;
			}
			return $returned_val; //Valeur en sortie
		}
	else{
		return false;
	}
}


// * Extraire l'id d'une table ?partir du nom d'un de ses champs
// * NB: Ici, on utilise une valeur comme pivot (WHERE CLAUSE) appartenant ?un champ
function get_field_by_id($tble,$field_id,$field_src,$usr_entry){ //ex: get_id_tbl("gpe","id_gpe","lib_gpe",$select_gpe) prend l'id_pe correspondant au lib_gpe choisi ds la table gpe
	global $MyFileConnect;
	$query = "SELECT $field_src FROM $tble WHERE $field_id = '$usr_entry'";
	$result = mysql_query($query,$MyFileConnect) or die("Erreur d'extraction <br>".mysql_error());
		if($total = mysql_num_rows($result)){
			while($row = mysql_fetch_object($result)){
				$returned_val = $row->$field_src;
			}
			return $returned_val; //Valeur en sortie
		}
	else{
		return false;
	}
}

// * Extraire noms et pr?oms ?partir de l'ID
function get_identity_by_id($tble,$field_id,$field_FirstName,$field_LastName,$usr_entry){ //ex: get_id_tbl("gpe","id_gpe","lib_gpe",$select_gpe) prend l'id_pe correspondant au lib_gpe choisi ds la table gpe
	global $MyFileConnect;
	$query = "SELECT $field_FirstName, $field_LastName FROM $tble WHERE $field_id = '$usr_entry'";
	$result = mysql_query($query,$MyFileConnect) or die("Erreur d'extraction <br>".mysql_error());
		if($total = mysql_num_rows($result)){
			while($row = mysql_fetch_object($result)){
				$returned_val = ucfirst($row->$field_FirstName)." ".strtoupper($row->$field_LastName);
			}
			return $returned_val; //Valeur en sortie
		}
	else{
		return false;
	}
}
function get_field_by_id_default($tble,$field_id,$field_src,$usr_entry, $defaultVal){ //ex: get_id_tbl("gpe","id_gpe","lib_gpe",$select_gpe) prend l'id_pe correspondant au lib_gpe choisi ds la table gpe
	global $MyFileConnect;
	$query = "SELECT $field_src FROM $tble WHERE $field_id = '$usr_entry'";
	$result = mysql_query($query,$MyFileConnect) or die("Erreur d'extraction <br>".mysql_error());
		if($total = mysql_num_rows($result)){
			while($row = mysql_fetch_object($result)){
				$returned_val = $row->$field_src;
			}
			return $returned_val; //Valeur en sortie
		}
	else{
		return $defaultVal;
	}
}

// *** Fin de la mise ?jour d'un enregistrement

// * Personnalisation pour BSA
function adduser_bsa($login,$pass,$matric,$gpe_id){
	global $MyFileConnect;
	$result = mysql_query("INSERT INTO usr VALUES('$login', '$pass', '$matric', '$gpe_id')", $MyFileConnect);
	return true;
}

// *** Fin des requetes personnalis?s


//* S?ectionner ts les enregistrements de la table $table index? par le champ $field dans un where clause
	function combo_sel_row_indexed2($table, $field_to_show, $hidden_val_field, $field_where, $index){
		global $MyFileConnect;
		$query = "SELECT $field_to_show, $hidden_val_field FROM $table WHERE $field_where = \"$index\"";
		$result = mysql_query($query) or die ("Erreur SQL! ".mysql_error());
		if($total = mysql_num_rows($result)){
			while($row = mysql_fetch_array($result)){
				print "<option value = ".$row["$hidden_val_field"].">".$row["$field_to_show"]."</option>";
			}
		}
		else{
			print "<option>Aucun</option>";
		}
	}
// ***	Fin combo_sel_row_indexed2

//* S?ectionner ts les enregistrements correspondant aux champs $field_to_show1 et $field_to_show2 de la table $table index? par le champ $field dans un where clause
	function combo2_sel_row_indexed2($table, $field_to_show1, $field_to_show2, $hidden_val_field, $field_where, $index){
		global $MyFileConnect;
		$query = "SELECT $field_to_show1, $field_to_show2, $hidden_val_field FROM $table WHERE $field_where = \"$index\"";
		$result = mysql_query($query) or die ("Erreur SQL! ".mysql_error());
		if($total = mysql_num_rows($result)){
			while($row = mysql_fetch_array($result)){
				print "<option value = ".$row["$hidden_val_field"].">".$row["$field_to_show1"]." ".$row["$field_to_show2"]."</option>";
			}
		}
		else{
			print "<option>Aucun</option>";
		}
	}
// ***	Fin combo2_sel_row_indexed2

// Les mises ?jour
	//POur 1 seul enregistrement
	function set_updated_1($table, $updated_field, $updated_value, $field_where, $user_entry){
		global $MyFileConnect;
		$query = "UPDATE $table SET $updated_field = $updated_value  WHERE $field_where = '$user_entry'";
		$result = mysql_query($query,$MyFileConnect) or die("Erreur de mise ?jour de champ <br>".mysql_error());
		return true;
	}
	//Pour tous les enregistrements
	function set_updated_all($table, $updated_field, $updated_value){
		global $MyFileConnect;
		$query = "UPDATE $table SET $updated_field = $updated_value";
		$result = mysql_query($query,$MyFileConnect) or die("Erreur de mise ?jour de champ <br>".mysql_error());
		return true;
	}
	
//  *** Retourne le sexe en d?ail 
	function sexe_lib($sexvar){
		$sex = ($sexvar = "M"?"Masculin":"Feminin");
		return $sex;
	}
	
//Vider une table
function clear_tbl($tbl){
	global $MyFileConnect;
	$query = "DELETE FROM $tbl";
	$result = mysql_query($query, $MyFileConnect) or die("Erreur de DML<br>".mysql_error());
	if($result){
		msgbox("Table $tbl vid?");
		return true;
	}
	else return false;
}
//POur camrail secu
function getday($day){ 
//entree, day en mysql
//Transformation du date_fr en date_mysql:
	//$day = date_mysql($day);
//requete pour savoir quel chifre lui attribuer ds notr intervalle:
global $day_num;
	$day_num = get_field_by_id("jour","id_jour","lib_jour",$day);
	return $day_num;
	print $day_num;
}

#Extraire tous les enregistrements dont la date est comprise entre '$val_date' et $x mois avant.
function query_interv($tbl, $date_fld, $val_date, $x){
	global $MyFileConnect;
	$query = "SELECT * FROM $tbl WHERE `$date_fld` BETWEEN ('$val_date' - INTERVAL $x MONTH) AND '$val_date'";
	if($result = mysql_query($query, $MyFileConnect))
		return true;
	else 
		die("Erreur de DML sur intervalle de dates <br>".mysql_error());
	}

#Bo?e de sondage horizontale	
function h_db_rate($tbl, $fld_id, $fld_value){
	global $MyFileConnect;
	$query = "SELECT * FROM $tbl ORDER BY '$fld_id' ASC";
	$result = mysql_query($query, $MyFileConnect) or die("Erreur!! <br />".mysql_error());
	if($total = mysql_num_rows($result)){
		print "<table><tr>";
		while($row = mysql_fetch_object($result)){
			print "<td><input name=\"wu_radio\" type=\"radio\" value=\"".$row->$fld_id."\"></td><td>".$row->$fld_value."</td>";
		}
		print "</tr></table>";
	}
}


//MISES A JOUR DES PAGES CHEZ SOLUTION TECHNOLOGY CORPORATION
function soltech_maj($page_id){
	global $MyFileConnect;
	$query = "SELECT * FROM `st_page_maj` WHERE `pages_id` = '$page_id' AND display='1'";
	$result = mysql_query($query, $MyFileConnect) or die("Impossible d'afficher les donn?s<br />".mysql_error());
	if($total = mysql_num_rows($result)){
		while($row = mysql_fetch_object($result)){
			$page_title = $row->maj_header; //Titre de la page
			$page_header = $row->maj_lib;   //Titre de la rubrique
			$page_content = $row->maj_content; //Contenu de la page
		}
		$page_maj = array($page_title, $page_header, $page_content);
	}
	return $page_maj;
}
//MODULE POUR L'AFFICHAGE RANDOMISE DES PRODUITS PHARES DE SOLUTION TECHNOLOGY
          //On teste si le nombre de produits phares est inferieur ou ?al au maximum autoris?
function chk_nbphare($nbmax){
	$nbre = (count_in_tbl_where("st_produit","is_phare",1));
	if( $nbre < $nbmax)
		return true;
	else
		return false;
}


function set_phare_limited($table, $phare_field, $phare_val, $prod_field, $prod_val, $limit){
	if(chk_nbphare($limit)){
		global $MyFileConnect;
		$query = "UPDATE $table SET $phare_field = '$phare_val' WHERE $prod_field = '$prod_val'";
		$result = mysql_query($query) or die("Erreur de mise ?jour".mysql_error());
		if($result){
			return true;
		}
		else{
			return false;
		}
	}
	else
		return false;
}

function del_entry($tbl, $field, $where){
	global $MyFileConnect;
	$query = "DELETE FROM $tbl WHERE $field = '$where'";
	if($request = mysql_query($query, $MyFileConnect))
		return true;
	else{
		die("Erreur de suppression de l'entree <br />".mysql_error());
		return false;
	}
}

// * Charger les valeurs de deux champ $field1 et $field ds un combobox avec concat?ation ex: prenom nom pour Guy ZINGUI***
	function journ_combo2_sel_row_2($table, $field_id, $field_val1, $field_val2){
	/*$table = la table de la bdd
	  $field = champ de la bdd concern?
	  $val = la valeur ?inserer ds les options, ki seront r?up??s*/
		global $MyFileConnect;
		$query = "SELECT * FROM $table ORDER BY $field_val1";
		$result = mysql_query($query, $MyFileConnect) or die("Erreur de s&eacute;lection de donn&eacute;es ds la bdd <br>".mysql_error());
		if($total = mysql_num_rows($result)){
			while($row = mysql_fetch_object($result)){
				$id = $row->$field_id;
				$val1 = $row->$field_val1;
				$val2 = $row->$field_val2;
				print "<option value=\"$id\">$val1 (N?$val2)</option>\n"; // Guy(prenom) ZINGUI(nom)
			}
		}
	}
// fonction de Menu de redirection redirection
	function combo_redirect($table, $field_id, $field_val, $field_order, $link, $valueGet){
	/*$table = la table de la bdd
	  $field = champ de la bdd concern?
	  $val = la valeur ?inserer ds les options, ki seront r?up??s*/
		global $MyFileConnect;
		$query = "SELECT $field_id, $field_val FROM $table ORDER BY $field_order";
		$result = mysql_query($query, $MyFileConnect) or die("Erreur de s&eacute;lection de donn&eacute;es ds la bdd <br>".mysql_error());
		if($total = mysql_num_rows($result)){
			while($row = mysql_fetch_object($result)){
				$id = $row->$field_id;
				$val = $row->$field_val;
				echo "<option value=". $link ."&mID=".$id." " . cmb_show_content($id, $valueGet) . ">".ucfirst(chapo($val, 30))."</option>\n";
			}
		}
	}
	
	function combo_redirect_annee($table, $field_id, $field_val, $field_order, $link, $valueGet){
	/*$table = la table de la bdd
	  $field = champ de la bdd concern?
	  $val = la valeur ?inserer ds les options, ki seront r?up??s*/
		global $MyFileConnect;
		$query = "SELECT $field_id, $field_val FROM $table ORDER BY $field_order";
		$result = mysql_query($query, $MyFileConnect) or die("Erreur de s&eacute;lection de donn&eacute;es ds la bdd <br>".mysql_error());
		if($total = mysql_num_rows($result)){
			while($row = mysql_fetch_object($result)){
				$id = $row->$field_id;
				$val = $row->$field_val;
				echo "<option value=". $link ."&aID=".$id." " . cmb_show_content($id, $valueGet) . ">".ucfirst(chapo($val, 30))."</option>\n";
			}
		}
	}
//
	function combo_sel_value($table, $field_id, $field_val, $field_order, $chmp){
	/*$table = la table de la bdd
	  $field = champ de la bdd concern?
	  $val = la valeur ?inserer ds les options, ki seront r?up??s
	  $chmp = le nom du champ ?verifier*/
		global $MyFileConnect;
		$query = "SELECT $field_id, $field_val FROM $table ORDER BY $field_order";
		$result = mysql_query($query, $MyFileConnect) or die("Erreur de s&eacute;lection de donn&eacute;es ds la bdd <br>".mysql_error());
		if($total = mysql_num_rows($result)){
			while($row = mysql_fetch_object($result)){
				$id = $row->$field_id;
				$val = $row->$field_val;
				echo "<option value='". $id ."'" . cmb_show_content($id, $_POST[$chmp]) . ">".ucfirst(chapo($val, 30))."</option>\n";
			}
		}
	}
	function combo_sel_annee($table, $field_val, $field_order, $chmp){
	/*$table = la table de la bdd
	  $field = champ de la bdd concern?
	  $val = la valeur ?inserer ds les options, ki seront r?up??s
	  $chmp = le nom du champ ?verifier*/
		global $MyFileConnect;
		$query = "SELECT $field_val FROM $table ORDER BY $field_order";
		$result = mysql_query($query, $MyFileConnect) or die("Erreur de s&eacute;lection de donn&eacute;es ds la bdd <br>".mysql_error());
		if($total = mysql_num_rows($result)){
			while($row = mysql_fetch_object($result)){
				$val = $row->$field_val;
				echo "<option value='". $val ."'" . cmb_show_content($id, $_POST[$chmp]) . ">".ucfirst(chapo($val, 30))."</option>\n";
			}
		}
	}
//
	function combo_sel_value2($id, $chmp){
				echo "<option value='". $id ."'" . cmb_show_content($id, $_POST[$chmp]) . ">".ucfirst(chapo($id, 30))."</option>\n";
	}
//function cwd_getMyDate($tbl)
?>