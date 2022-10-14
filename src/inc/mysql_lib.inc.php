<?php

/*************************************
*  Connexion / d?onnexion ?la bdd  *
**************************************/

function connect_2_db(){
	//Initialisation des vars de connexion
	global $st_connect;
	//********** Vous pouvez modifier les valeurs ci-dessous afin de s?uriser la base *************************
	$host = "localhost:3301";//"mysql2.co.fr.clara.net";
	$db   = "solution_db";
	$usr  = "root";//"solution_db";
	$pass = "";//"solutiondev";
	//**************************************
	
	//*********************************************************************************************************************************
	//************************* Code ?ne surtout pas toucher, sinon pouvant destabiliser les ??ents du site ************************
	//*********************************************************************************************************************************	
	
	$st_connect = mysql_pconnect($host,$usr,$pass) or die("Erreur de connexion ?la base de donn&eacute;es...<br>".mysql_error());
	mysql_select_db($db) or die ("Erreur lors de la selection de la base de donn&eacute;es ".mysql_error());
}
//***** Fin cha?e de connexion *****

//Lorskon a un enregistrement null, on retourne la cha?e R.A.S
function rewrite_record($record){
	if($record = ""){
		$record = "R.A.S";
	}
	return $record;
}

function rewrite_record2($record){
	if($record = ""){
		$record = "";
	}
	return $record;
}


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
function count_in_tbl($tbl,$field)
    {
	global $st_connect;
	$select = "SELECT count($field) FROM $tbl";
	$result = mysql_query($select)  or die("Erreur de selection du nombre ".mysql_error());
	$row = mysql_fetch_row($result);
	$total = $row[0];
	//echo $total;
	return $total;
	mysql_free_result($result);
    }
	
	//Comptage suivant un crit?e particulier
	function count_in_tbl_where($tbl,$field,$where)
    {
	global $st_connect;
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
	global $st_connect;
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
		global $st_connect;
		$query = "SELECT `$field` FROM $tbl WHERE `$where_field` = '$where_value'";
		$result = mysql_query($query, $st_connect)  or die("Erreur de selection <br />".mysql_error());
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
		
//A utiliser de preference
function show_last_where_ordered($tbl, $field, $where_field, $where_value, $order_field){
		global $st_connect;
		$query = "SELECT `$field` FROM $tbl WHERE `$where_field` = '$where_value' AND `display` = '1' ORDER BY $order_field ASC";
		$result = mysql_query($query, $st_connect)  or die("Erreur de selection <br />".mysql_error());
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
	global $st_connect;
	$query = "SELECT * FROM `$tbl` WHERE `$field` = '$entry'";
	$result = mysql_query($query, $st_connect) or die ("Erreur d'extraction des donn?s dans la base ".mysql_error());
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
	global $st_connect;
	$query = "SELECT * FROM $tbl WHERE $field = '$entry' and $fieldtest = '$entrytest'";
	$result = mysql_query($query, $st_connect) or die ("Erreur d'extraction des donn?s de la base ".mysql_error());
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
	global $st_connect;
	global $query;
	$query = "SELECT $usr_field, $pass_field FROM $tbl WHERE $usr_field = '$usr_entry' AND $pass_field = '$pass_entry'";
	$result = mysql_query($query, $st_connect) or die ("Erreur d'extraction des donn?s dans la base ".mysql_error());
	$row = mysql_fetch_row($result);
	if($total = $row[0])  //Mysql ?g???au moins 1 resultat 
		return true;
	}
	
#Crypt?
function chk_usr_pass_enc($tbl, $usr_field, $pass_field, $usr_entry, $pass_entry)  //$tbl = latable a indexer, $field = le champ concern? $entry = la valeur ?tester prise ds le formulaire
	{
	global $st_connect, $query;
	$pass_entry = md5($pass_entry);
	$query = "SELECT $usr_field, $pass_field FROM $tbl WHERE $usr_field = '$usr_entry' AND $pass_field = '$pass_entry'";
	$result = mysql_query($query, $st_connect) or die ("Erreur d'extraction des donn?s dans la base ".mysql_error());
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
	global $st_connect, $query;
	$query = "SELECT * FROM $tbl WHERE $usr_fld = '$usr_entry' AND $pass_fld = '$pass_entry' AND $status_fld = '$status_value'";
	$result = mysql_query($query, $st_connect) or die ("Erreur d'extraction des donn?s dans la base ".mysql_error());
	$row = mysql_fetch_row($result);
	if($total = $row[0])  //Mysql ?g???au moins 1 resultat 
	return true;
}
	
#Crypt?
function chk_usr_pass_status_enc($tbl, $usr_field, $pass_field, $status_field, $usr_entry, $pass_entry, $status_value)  //$tbl = latable a indexer, $field = le champ concern? $entry = la valeur ?tester prise ds le formulaire
	{
	global $st_connect, $query;
	$pass_entry = md5($pass_entry);
	$query = "SELECT $usr_field, $pass_field FROM $tbl WHERE $usr_field = '$usr_entry' AND $pass_field = '$pass_entry' AND $status_field = '$status_value'";
	$result = mysql_query($query, $st_connect) or die ("Erreur d'extraction des donn?s dans la base ".mysql_error());
	$row = mysql_fetch_row($result);
	if($total = $row[0])  //Mysql ?g???au moins 1 resultat 
		return true;
	}
	
	
function chk_usr_pass_status_enc2($tbl, $usr_field, $pass_field, $status_field, $usr_entry, $pass_entry, $status_value, $where_field, $where_val)  //$tbl = latable a indexer, $field = le champ concern? $entry = la valeur ?tester prise ds le formulaire
	{
	global $st_connect, $query;
	$pass_entry = md5($pass_entry);
	$query = "SELECT $usr_field, $pass_field FROM $tbl WHERE $usr_field = '$usr_entry' AND $pass_field = '$pass_entry' AND $status_field = '$status_value' AND $where_field = '$where_val'";
	$result = mysql_query($query, $st_connect) or die ("Erreur d'extraction des donn?s dans la base ".mysql_error());
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
	global $st_connect;
	$result = mysql_query("INSERT INTO $tbl (login, password) VALUES ($login, $password)", $st_connect);
	return mysql_insert_id($st_connect);
    }
//*********** Fin d'ajout d'utilisateur ****************
	//Connecter ou deconnecter un user
	function set_connected($table, $field, $login_field, $user_entry, $val){
		 //$val est un booleen qui indique si l'on est connect?ou pas
		global $st_connect;
		$query = "UPDATE $table SET $field = '$val' WHERE $login_field = '$user_entry'";
		$result = mysql_query($query,$st_connect) or die("Erreur de mise ?jour de champ <br>".mysql_error());
	}


	function add_entry5($table,$field1,$field2,$field3,$field4,$field5,$entry1,$entry2,$entry3,$entry4,$entry5){
		global $st_connect;
		$query = "INSERT INTO $table($field1,$field2,$field3,$field4,$field5) VALUES('$entry1','$entry2','$entry3','$entry4','$entry5')";
		$result = mysql_query($query,$st_connect) or die("Erreur d'ajout d'enregistrement:<br>".mysql_error());
		$total = mysql_affected_rows($st_connect);
		if($total>=1){
			/*print "<script>alert('Entr? ajout? avec succ?')</script>";*/
			return true;
		}
		else{
			return false;
		}
	}
	
	
		function add_guestbook($gbtable, $field1, $field2, $field3, $field4, $field5, $field6, $entry1, $entry2, $entry3, $entry4, $entry5, $entry6){
		global $st_connect;
		$query = "INSERT INTO $gbtable($field1,$field2,$field3,$field4,$field5) VALUES('$entry1','$entry2','$entry3','$entry4','$entry5')";
		$result = mysql_query($query,$st_connect) or die("Erreur d'ajout d'enregistrement:<br>".mysql_error());
		$total = mysql_affected_rows($st_connect);
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
		global $st_connect;
		$query = "DELETE FROM $table WHERE `$field_where` = '$entry'";
		$result = mysql_query($query, $st_connect) or die("Erreur de retrait d'une entr&eacute;e dans la bdd <br>".mysql_error());
	}
// *** Fin Suppression de l'enregistrement
	
	
// * Charger les valeurs d'un champ $field ds un combobox***
	function combo_sel_row($table,$field){
	/*$table = la table de la bdd
	  $field = champ de la bdd concern?
	  $val = la valeur ?inserer ds les options, ki seront r?up??s*/
		global $st_connect;
		$query = "SELECT $field FROM $table";
		$result = mysql_query($query,$st_connect) or die("Erreur de s&eacute;lection de donn&eacute;es ds la bdd <br>".mysql_error());
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
		global $st_connect;
		$query = "SELECT $field_id, $field_val FROM $table ORDER BY $field_val";
		$result = mysql_query($query, $st_connect) or die("Erreur de s&eacute;lection de donn&eacute;es ds la bdd <br>".mysql_error());
		if($total = mysql_num_rows($result)){
			while($row = mysql_fetch_object($result)){
				$id = $row->$field_id;
				$val = $row->$field_val;
				print "<option value=\"$id\">$val</option>\n";
			}
		}
	}
// *** Fin chargement combo


// * Charger les valeurs d'un champ $field ds un combobox condition?par une valeur $valwhere du champ $wherefield***
	function combo_sel_row_where($table, $field_id, $field_val, $where_field, $where_val){
	/*$table = la table de la bdd
	  $field = champ de la bdd concern?
	  $val = la valeur ?inserer ds les options, ki seront r?up??s*/
		global $st_connect;
		$query = "SELECT $field_id, $field_val FROM $table WHERE $where_field = '$where_val' ORDER BY $field_val";
		$result = mysql_query($query, $st_connect) or die("Erreur de s&eacute;lection de donn&eacute;es ds la bdd <br>".mysql_error());
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
		global $st_connect;
		$query = "SELECT $field_id, $field_val FROM $table ORDER BY $field_val";
		$result = mysql_query($query, $st_connect) or die("Erreur de s&eacute;lection de donn&eacute;es ds la bdd <br>".mysql_error());
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
		global $st_connect;
		$query = "SELECT * FROM $table ORDER BY $field_val1";
		$result = mysql_query($query, $st_connect) or die("Erreur de s&eacute;lection de donn&eacute;es ds la bdd <br>".mysql_error());
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
		global $st_connect;
		$query = "DELETE FROM $table WHERE $field = '$selected'";
		$result = mysql_query($query,$st_connect) or die("Impossible de supprimer...<br>".mysql_error());
		if($result){
			print "<script>alert('Suppression de $selected effectu? avec succ?...')</script>";
		}
		else{
			print "<script>alert('Impossible de supprimer $selectted ...')</script>";
		
		}
		return (mysql_affected_rows($st_connect));
	}
// *** Fin suppression d'enregistrement ?partir d'un champ
	

//* S?ectionner ts les enregistrements de la table $table index? par le champ $field
	function combo_get_row_indexed($table,$field,$index){
		global $st_connect;
		$query = "SELECT * FROM $table WHERE $field = '$index'";
		$result = mysql_query($query) or die ("Erreur SQL! ".mysql_error());
		if($total = mysql_num_rows($result, $st_connect)){
			while($row = mysql_fetch_array($result)){
				print "<option>".$row["$field"]."</option>";
			}
		}
		else{
			print "<option>Aucun</option>";
		}
	}
// ***	Fin combo_get_row_indexed


// * Mettre le champ $field_to update de la table $table ?jour ?l'aide de la valeur $val_updated suivantla clause $where 
// * NB: On peut ajouter d'autres champ ?mettre ?jour
	function update_entry($table,$field_to_update,$val_updated,$where){
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
// *** Fin de la mise ?jour d'un enregistrement

// * Extraire l'id d'une table ?partir du nom d'un de ses champs
// * NB: Ici, on utilise une valeur comme pivot (WHERE CLAUSE) appartenant ?un champ
function get_id_tbl($tble,$field_id,$field_test,$usr_entry){ //ex: get_id_tbl("gpe","id_gpe","lib_gpe",$select_gpe) prend l'id_pe correspondant au lib_gpe choisi ds la table gpe
	global $st_connect;
	$query = "SELECT $field_id FROM $tble WHERE $field_test = '$usr_entry'";
	$result = mysql_query($query,$st_connect) or die("Erreur d'extraction <br>".mysql_error());
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
	global $st_connect;
	$query = "SELECT $field_src FROM $tble WHERE $field_id = '$usr_entry'";
	$result = mysql_query($query,$st_connect) or die("Erreur d'extraction <br>".mysql_error());
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

// *** Fin de la mise ?jour d'un enregistrement

// * Personnalisation pour BSA
function adduser_bsa($login,$pass,$matric,$gpe_id){
	global $st_connect;
	$result = mysql_query("INSERT INTO usr VALUES('$login', '$pass', '$matric', '$gpe_id')", $st_connect);
	return true;
}

// *** Fin des requetes personnalis?s


//* S?ectionner ts les enregistrements de la table $table index? par le champ $field dans un where clause
	function combo_sel_row_indexed2($table, $field_to_show, $hidden_val_field, $field_where, $index){
		global $st_connect;
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
		global $st_connect;
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



	function set_updated_1($table, $updated_field, $updated_value, $field_where, $user_entry){
		global $st_connect;
		$query = "UPDATE $table SET $updated_field = $updated_value  WHERE $field_where = '$user_entry'";
		$result = mysql_query($query,$st_connect) or die("Erreur de mise ?jour de champ <br>".mysql_error());
		return true;
	}
	
//  *** Retourne le sexe en d?ail 
	function sexe_lib($sexvar){
		$sex = ($sexvar = "M"?"Masculin":"Feminin");
		return $sex;
	}
	
//Vider une table
function clear_tbl($tbl){
	global $st_connect;
	$query = "DELETE FROM $tbl";
	$result = mysql_query($query, $st_connect) or die("Erreur de DML<br>".mysql_error());
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
	global $st_connect;
	$query = "SELECT * FROM $tbl WHERE `$date_fld` BETWEEN ('$val_date' - INTERVAL $x MONTH) AND '$val_date'";
	if($result = mysql_query($query, $st_connect))
		return true;
	else 
		die("Erreur de DML sur intervalle de dates <br>".mysql_error());
	}

#Bo?e de sondage horizontale	
function h_db_rate($tbl, $fld_id, $fld_value){
	global $st_connect;
	$query = "SELECT * FROM $tbl ORDER BY '$fld_id' ASC";
	$result = mysql_query($query, $st_connect) or die("Erreur!! <br />".mysql_error());
	if($total = mysql_num_rows($result)){
		print "<table><tr>";
		while($row = mysql_fetch_object($result)){
			print "<td><input name=\"st_radio\" type=\"radio\" value=\"".$row->$fld_id."\"></td><td>".$row->$fld_value."</td>";
		}
		print "</tr></table>";
	}
}

?>