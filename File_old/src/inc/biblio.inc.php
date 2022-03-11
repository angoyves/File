<?php

//Afficher des nombres ds un combo box dans un l'ordre: 
//ASCENDANT
function get_xint_ASC($valIni, $valFin, $inc=1){
	$return = "";
	for($i=$valIni; $i<=$valFin; $i+=$inc){
		$return .= "<option value=$i>$i</option>\n";
	}
	return $return;
}
//DESCENDANT
function get_xint_DESC($valFin, $valIni, $inc=1){
	$return = "";
	for($i=$valFin; $i>=$valIni; $i-=$inc){
		$return = "<option value=$i>$i</option>\n";
	}
	return $return;
}

//Reinitialise le compteur et va à la ligne pour les output de recordset sur +eurs colonnes

#SANS TABLEAU
function br_reset($counter, $break_val){
	if(($counter % $break_val) == 0){
		print "<br />";
		//$counter = 0;
	}
}

#AVEC TABLEAU
function br_reset2($counter, $break_val){
	if(($counter % $break_val) == 0){
		print "</tr><tr>";
		//$counter = 0;
	}
}

//Reformate l'url en http://www.server.com..... si on tape www.server.com
function domain_restaure($entry) {
	#Regarder dans ma BSA Library
	$domain_result = ((substr($entry,0,6)!="http://")?"http://$entry":"$entry");
	return $domain_result;
}

//Affiche un lien alternatif en fonction de ma valeur test_val(1 ou 0, lien si 1 - lien si 0)
//Ex: alternalink($row_SelDossiers['display'], "masquer.php", "Masquer", "afficher.php", "Afficher", "1");
function alternalink($test_val, $link_ok, $txt_ok, $link_not, $txt_not, $pattern){
	$returned_val = ($test_val==$pattern)?("<a href=\"$link_ok\" title=\"Cliquez pour d&eacute;sactiver\">$txt_ok</a>"):("<a href=\"$link_not\" title=\" Cliquez pour activer\">$txt_not</a>");
	return $returned_val;
}

function alternapix($test_val, $src_ok, $src_not, $pattern){
	$returned_pic = ($test_val==$pattern)?("<img border=\"0\" src=\"$src_ok\" alt=\"Cliquez pour d&eacute;sactiver\" />"):("<img alt=\"Cliquez pour activer\" border=\"0\" src=\"$src_not\" />");
	return $returned_pic;
}

function alternapixUrl($test_val, $src_ok, $url_ok, $src_not, $url_not, $pattern){
	$returned_pic = ($test_val==$pattern)?("<a href=\"$url_ok\"><img border=\"0\" src=\"$src_ok\" alt=\"Cliquez pour d&eacute;sactiver\" /></a>"):("<a href=\"$url_not\"><img border=\"0\" src=\"$src_not\" alt=\"Cliquez activer\" /></a>");
	return $returned_pic;
}




//Affichage pour recherche alphabétique

function alpha_search($link, $param){
	for($i=65; $i<=90; $i++)
	print "<a href = \"$link?$param=".chr($i)."\">".chr($i)."</a>&nbsp; &nbsp;";
}

// Nbre d'espacements - &nbsp;
function nbsp($n){
	for($i=1; $i<=$n; $i++){
		print "&nbsp;";
	}
}

// Nbre de retour charriots - <br />
function br($n){
	for($i=1; $i<=$n; $i++){
		print "<br />";
	}
}

// CCERI-line
function line1(){
	print "<font color=\"#33CC33\">-------------------------------------------------------------------------------------------------------------------------------------------------------------------</font>";
}

function dotted_line($nb, $col){
	$nb = (isset($nb)?"$nb":10);
	$col = (isset($col))?"$col":"#000000";
	for($i=1; $i<=$nb; $i++){
		print "<font color=\"$col\">-</font>";
	}
}

function dotted_line2($nb, $col){
	$nb = (isset($nb)?"$nb":10);
	$col = (isset($col))?"$col":"#000000";
	for($i=1; $i<=$nb; $i++){
		print "<font color=\"$col\">- </font>";
	}
}

function img_repeater($nb, $imgUrl){
	$nb = (isset($nb)?"$nb":1);
	$col = (isset($imgUrl))?"$imgUrl":"images/img/";
	for($i=1; $i<=$nb; $i++){
		print "<img src=\"$imgUrl\" />".nbsp(1);
	}
}

//Affichage dynamique des <list>
function show_list($record){
	$list = ($record == "")?"":"<li>";
	return $list;
}

//Repertoires d'upload
# Les images pour l'annonce
$dir_img_annonce = "..images/img/annonces";

//Transformation de la date mysql en date affichable jj/mm/aaaa

function month_converter($num_month){
	switch($num_month){
		case "01" : $to_return = "Janvier";
		break;
		case "02" : $to_return = "Février";
		break;
		case "03" : $to_return = "Mars";
		break;
		case "04" : $to_return = "Avril";
		break;
		case "05" : $to_return = "Mai";
		break;
		case "06" : $to_return = "Juin";
		break;
		case "07" : $to_return = "Juillet";
		break;
		case "08" : $to_return = "Août";
		break;
		case "09" : $to_return = "Septembre";
		break;
		case "10" : $to_return = "Octobre";
		break;
		case "11" : $to_return = "Novembre";
		break;
		case "12" : $to_return = "Décembre";
		break;
		default   : $to_return = "";
	}
	return $to_return;
}


function cmb_loadMonthsFr(){
	$month_out = "";
	$varmois = array("01"=>"Janvier","02"=>"Fevrier","03"=>"Mars","04"=>"Avril","05"=>"Mai","06"=>"Juin","07"=>"Juillet","08"=>"Août","09"=>"Septembre","10"=>"Octobre","11"=>"Novembre","12"=>"Décembre");
	foreach ($varmois as $key=>$value){
		if($key == (int)date("m"))
			$month_out .= "<option value=\"$key\" selected>$value</option><br />\n";
		$month_out .= "<option value=\"$key\">$value</option><br />\n";
	}
	return $month_out;
}

function cmb_loadMonthsEn(){
	$month_out = "";
	$varmois = array("01"=>"January","02"=>"Febuary","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December");
	foreach ($varmois as $key=>$value){
		if($key == (int)date("m"))
			$month_out .= "<option value=\"$key\" selected>$value</option><br />\n";
		$month_out .= "<option value=\"$key\">$value</option><br />\n";
	}
	return $month_out;
}

function cmb_loadYears($yIni){
	(int)$yFinal = date("Y"); //Recup la date courante
	$year_out = "";
	for($i=$yIni; $i<=($yFinal-15); $i+=1){//Restriction aux moins de 15 ans
		if((int)$i==$yFinal)
			$year_out .= "<option value = \"$i\" selected>$i</option>";
		$year_out .= "<option value = $i>$i</option>";
	}
	return $year_out;
}

function cmb_loadYears2($yIni){
	(int)$yFinal = date("Y"); //Recup la date courante
	$year_out = "";
	for($i=$yIni; $i<=($yFinal); $i+=1){
		if((int)$i==$yFinal)
			$year_out .= "<option value = \"$i\" selected>$i</option>";
		$year_out .= "<option value = $i>$i</option>";
	}
	return $year_out;
}

function cmb_loadDays(){
	$day_out = "";
	for($i=1; $i<=31; $i++){
		if($i==(int)date("d"))
			$day_out .= "<option value = \"$i\" selected>$i</option>";
		$day_out .= "<option value = $i>$i</option>";
	}
	return $day_out;
}

//Du format MySQL au format francophone
function date_fr($date_mysql){
	list($year,$month,$day) = explode("-",$date_mysql);
	$date_to_return = $day."/".$month."/".$year;
	if($day == "00")
		$date_to_return = $month."/".$year;
	return $date_to_return;
}
//Uniquement pour l'ARTet utile aussi pour parser une chaîne de caractère composée avec des séparateurs
function read_transmission($val){
	//$tab[];
	 //;
	foreach(explode("**", $val) as $value){
		$val.= $value."<br />";
	}
	return $val;
}

function date_fr2($date_mysql){
	list($year,$month,$day) = explode("-",$date_mysql);
	$date_to_return = $day."/".$month."/".$year;
	if($day == "00")
		$date_to_return = month_converter($month)." ".$year;
	else
		$date_to_return = $day." ".month_converter($month)." ".$year;
	return $date_to_return;
}

//Du format francophone au format MySQL:
function date_en($date_fr){
	list($day,$month,$year) = explode("/",$date_fr);
	$date_to_return = $year."-".$month."-".$day;
	return $date_to_return;
}


//Du format mysql au format francophone alphanumerique
function date_convert_fr($date){
	list($year,$month,$day) = explode("-",$date_mysql);
	//if($day == "00") $day = "";
	$date_to_return = $day." ".$month." ".$year;
	return $date_to_return;
}

function get_day($date_mysql){
	list($year,$month,$day) = explode("-",$date_mysql);
	$date_to_return = $day;
	return $date_to_return;
}
function get_month($date_mysql){
	list($year,$month,$day) = explode("-",$date_mysql);
	$date_to_return = $month;
	return $date_to_return;
}
function get_year($date_mysql){
	list($year,$month,$day) = explode("-",$date_mysql);
	$date_to_return = $year;
	return $date_to_return;
}

//Pour les mises à jour des dates
function upd_loadDays(){
	$day_out = "";
	for($i=1; $i<=31; $i++){
		$day_out .= "<option value = $i>$i</option>";
	}
	return $day_out;
}

function upd_loadMonths(){
	$month_out = "";
	$varmois = array("01"=>"Janvier","02"=>"Fevrier","03"=>"Mars","04"=>"Avril","05"=>"Mai","06"=>"Juin","07"=>"Juillet","08"=>"Août","09"=>"Septembre","10"=>"Octobre","11"=>"Novembre","12"=>"Décembre");
	foreach ($varmois as $key=>$value){
  		/*if($key == (int)date("m"))
			$month_out .= "<option value=\"$key\" selected>$value</option><br />\n";*/
		$month_out .= "<option value=\"$key\">$value</option><br />\n";
	}
	return $month_out;
}

function upd_loadYears($yIni){
	(int)$yFinal = date("Y"); //Recup la date courante
	$year_out = "";
	for($i=$yIni; $i<=$yFinal; $i+=1){//Restriction aux moins de 15 ans
		$year_out .= "<option value = $i>$i</option>";
	}
	return $year_out;
}


//Insérer un bloc de date en combo: La meilleure actuellement pour bosser avec les dates.
function combo_dateFr($varNum=""){
	/*$varNum pour pouvoir avoir plusieurs occurence de cet objet dans une 
	page ou sur un formulaire, sans amalgame*/
	$cmb_return  = "<table><tr>
		<td><select name=\"cmbDay".$varNum."\">".cmb_loadDays()."</select></td>
		<td><select name=\"cmbMonth".$varNum."\">".cmb_loadMonthsFr()."</select></td>
		<td><select name=\"cmbYear".$varNum."\">".cmb_loadYears2(1910)."</select></td>
		</tr></table>";
	return $cmb_return;
}
/*La meilleure actuellement pour les mises à jour des dates à partir des comboBoxes
Pour recup le jour en sortie ici, $_POST['cmbDay']
Pour recup le mois en sortie ici, $_POST['cmbMonth']
Pour recup l'année en sortie ici, $_POST['cmbYear']
NB: Ces variables sont déclarée dans le header de la page qui appelle ce script.
après avoir récupéré les éléments de la date, les concatener pour enregistrer ds la bd une date au format MySQL
ex: $date = $_POST['cmbYear']."-".$_POST['cmbMonth']."-".$_POST['cmbDay']
*/
function combo_dateFrUpd($date_mysql, $varNum=""){
	/*$varNum pour pouvoir avoir plusieurs occurence de cet objet dans une 
	page ou sur un formulaire, sans amalgame*/
	$selDay = get_day($date_mysql); //Recupère le jour de la BD
	$selDayLabel = ($selDay == "00")?"--":"$selDay";
	
	$selMonth = get_Month($date_mysql); //Recupère le mois de la BD
	$selYear = get_Year($date_mysql); //Recupère l'année de la BD
	$cmb_return  = "<table><tr>
		<td><select name=\"cmbDayUpd\"".$varNum."><option value=\"$selDay\">$selDayLabel</option>".upd_loadDays()."</select></td>
		<td><select name=\"cmbMonthUpd\"".$varNum."><option value=\"$selMonth\">".month_converter($selMonth)."</option>".upd_loadMonths()."</select></td>
		<td><select name=\"cmbYearUpd\"".$varNum."><option value=\"$selYear\">$selYear</option>".upd_loadYears(1910)."</select></td>
		</tr></table>";
	return $cmb_return;
}
//Ex: combo_dateFrUpd($row_rsSelEnreg['dateField']);
// *** Fin dates

//****************************************  Script Pagination **********************************************************************

//Fonction vérifiant la validité de $limite dans le cadre de l'affichage page par page
function veriflimite($limite, $total, $nombre)
	{
	if(is_numeric($limite))
		{
		if(($limite >= 0) && ($limite <= $total) && ($limite%nombre == 0)) 
			{
			$valide = 1;
			}
		else $valide = 0;
		}
	else $valide = 0;
	return $valide;
	}


// affichage pages par pages	
function affichepage($nb, $page, $total)
	{
	$nbpage = ceil($total/$nb);
	$numpage = 1;
	$comptpage = 1;
	$limite = 0;
	echo "<table border = '0' align = 'right'><tr><td width = 100>Pages</td>"."\n";
	while ($numpage <= $nbpage)
		{
		echo "<td><a href = '".$page."?limite=".$limite."'>".$numpage."</a></td>"."\n";
		$limite = $limite + $nb;
		$numpage = $numpage + 1;
		$comptpage = $comptpage + 1;
		if($comptpage == 10)
			{
			$comptpage = 1;
			echo "<br>\n";
			}
		}
	echo "</tr></table>\n";
	}
//************************************************************** FIN PAGINATION ***************************************************	
	function show_content($err,$var){
		//Utile pour vider les champs lorsqu'il n'y a pas d'erreur lors de la validation du formulaire...
		if($err!=""){
			$var = stripslashes($var);
			print "$var";
		}
	}

	function cmb_show_content2($errVar, $testVar, $selVar){
		//Affiche la valeur sélectionnée ds le combobox après erreur d'envoi d'un formulaire
		if(($errVar!="") AND (!strcmp($testVar, $selVar))){
			return "SELECTED";
		}
	}
	function cmb_show_content($testVar, $selVar){
		//Affiche la valeur sélectionnée ds le combobox après erreur d'envoi d'un formulaire
		if((!strcmp($testVar, $selVar))){
			return "SELECTED";
		}
	}

/***********************************************************************************
*  Fonctions inhérentes à la date et à l'heure pour les formulaires et les traces  *
***********************************************************************************/
//echo "<h2>Affichage de la date</h2>\n";
$varjour = array("dimanche","lundi","mardi","mercredi","jeudi","vendredi","samedi");
$num_jour = date("w");
$jour = $varjour[$num_jour];

//echo "aujourdhui nous sommes un $jour";
$varmois = array("Janvier","Fevrier","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
$num_mois = date("n")-1; /* Car la première valeur doit etre o  (1-1 = 0) */


//echo "<br>nous sommes au mois de $varmois[$num_mois]";
$num_jour = date("d");
//echo "<br>aujourd'hui c'est le : $num_jour";

//formatage français
//$jour = $varjour[$num_jour];
$quant = $num_jour;
$mois = $varmois[$num_mois];
$annee = date("y");
//echo "<br>En resumé, la date d' aujourdhui c'est le : $jour $quant $mois 20$annee\n<br>"; 
#Fin des fonctions [date et trace pour formulaires et mouchards...]


/**************************************************
* Fonctions inhérentes aux pop-ups avec javascript*
**************************************************/

//Une petite boîte de dialogue
/*
echo'<script>
		function message(title, msg)
		{
  			var width="300", height="125";
  			var left = (screen.width/2) - width/2;
  			var top = (screen.height/2) - height/2;
  			var styleStr = \'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbar=no,resizable=no,copyhistory=yes,width=\'+width+\',height=\'+height+\',left=\'+left+\',top=\'+top+\',screenX=\'+left+\',screenY=\'+top;
  			var msgWindow = window.open("","msgWindow", styleStr);
  			var head = \'<head><title>\'+title+\'</title></head>\';
  			var body = \'<center>\'+msg+\'<br><p><form><input type="button" value="   Done   " onClick="self.close()"></form>\';
  			msgWindow.document.write(head + body);
		}
		</script>';
*/

function pop($url)    /* Les pop-ups à la volée */
   {
	echo "<script language = 'javascript'>
	window.open($url)
	</script>";
    echo "<script src = 'jsfiles/popup.js'></script>";  /* Ne pas oublier de tjrs appeler le js */
   }

#popup sans scrolling   
function popup($url, $width, $height){
		print "window.open('$url', '', 'directories=no, toolbar=no, scrollbars=1, resizable=1, width=$width, height= $height')";
  }

#popup sans scrolling   
function popup_noscroll($url, $width, $height){
	print "window.open('$url', '', 'directories=no, toolbar=no, scrollbars=0, resizable=0, width=$width, height= $height')";
  }

 #popup sans scrolling à utiliser dans une balise
function taggy_popup($url, $width, $height){
	print"
		window.open('".$url."', '', 'directories=no, toolbar=no, width=".$width." height=".$height.", scrolling=no')";
  }
  
#popup avec scrolling
function scrl_popup($url, $width, $height){
	print"<script>
		window.open('".$url."', '', 'directories=no, toolbar=no, width=".$width." height=".$height.", scrolling=yes');
		</script>";
  }

/*
	echo'<script>
		function gal_img(title, img)
		{
  			var width="350", height="300";
  			var left = (screen.width/2) - width/2;
  			var top = (screen.height/2) - height/2;
  			var styleStr = \'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbar=no,resizable=no,copyhistory=yes,width=\'+width+\',height=\'+height+\',left=\'+left+\',top=\'+top+\',screenX=\'+left+\',screenY=\'+top;
  			var msgWindow = window.open("","msgWindow", styleStr);
  			var head = \'<head><title>\'+title+\'</title></head>\';
  			var body = \'<center><img src="images/img/events/3agn2004/pix/\'+img+\'"><br><p><form><input type="button" value="   Fermer-Close   " onClick="self.close()"></form>\';
  			msgWindow.document.write(head + body);
		}
		</script>';
*/


function poppix($url)    /* Les pop-ups à la volée */
   {
	echo "<script language = 'javascript'>
	window.open($url)
	</script>";
    echo "<script src = 'jsfiles/poppix.js'></script>";  /* Ne pas oublier de tjrs appeler le js */
   }
#Fin des fonctions [Pop-ups]


/***************************************************
*  Fonctions inhérentes aux pages en construction  *
***************************************************/
function not_ready($img)   /* Pour les pages en construction    */
    {
	echo "<center><img src = '$img'></img></center>";
    }
#Fin fonctions [Pages en construction]


/*****************************************
*  Fonctions inhérentes à l'interfacage  *
******************************************/
function msgbox($alert){
echo'<script>alert("'.$alert.'");</script>';
}

//Check la validité du mail
function chk_mail($entry){
	if(eregi("^[_a-z 0-9]*@[a-z0-9]{3,}\.[a-z]{2,4}$",$entry)){
    	return true;
	}
}

function chk_mail_output($entry){
	if(eregi("^[_a-z 0-9]*@[a-z0-9]{3,}\.[a-z]{2,4}$",$entry)){
    	msgbox("Email invalide");
		return false;
	}
	else{
		return true;
	}
}


/*******************************************************
*          Fonctions inhérentes aux fichiers           *
********************************************************/
//Lire dans un fichier:
 function read_in_file($file){
		//$file = 'monfichier.txt'; // on déclare le nom du fichier à ouvrir
		$taille = filesize($file); //donne la taille du fichier
		$fp = fopen($file,'r') or die("Impossible de lire dans le fichier $file"); //ouverture du fichier en lecture seule
		while(!feof($fp)){ //feof indiquera la fin du fichier, donc dans cette boucle, le fichier est parcouru jusqu'à la fin
			$ligne = fgets($fp,$taille); //lecture du fichier et stockage dans la variable ligne
			print $ligne; //affiche la ligne à l'écran, n'oubliez pas le <br> qui est le retour à la ligne html 
		}
		fclose($fp); //pensez à refermer à la fin du script
	}


//Ecrire dans un fichier:
 function write_in_file($file, $content){
		//$file = 'monfichier.txt'; // on déclare le nom du fichier à ouvrir
		$fp = fopen($file,'w') or die("Impossible d'écrire dans le fichier $file"); //ouverture du fichier en lecture seule
		fwrite($fp,$content);
		fclose($fp);
		return true;
		}
	
//Réaliser un ajout dans un fichier
function add_in_file($file, $to_add){
	$fp = fopen($file,'a');
	fputs($fp, $to_add) or die("Impossible d'ajouter dans le fichier $file");
	fclose($fp);
	return true;
	}


function read_in_file2($file){
  	global $file_tab;
	//$file = 'monfichier.txt'; // on déclare le nom du fichier à ouvrir
	$taille = filesize($file); //donne la taille du fichier
	$file_tab = array();
	$fp = fopen($file,'r') or die("Impossible de lire dans le fichier $file"); //ouverture du fichier en lecture seule
	while(!feof($fp)){ //feof indiquera la fin du fichier, donc dans cette boucle, le fichier est parcouru jusqu'à la fin
		$ligne = fgets($fp,$taille); //lecture du fichier et stockage dans la variable ligne
		array_push($file_tab, $ligne); //rempli le tableau des valeurs
	}
	return $file_tab;
	fclose($fp); //pensez à refermer à la fin du script
 }

//Récupère les valeurs d'un fichier placés dans un tableau et les concatène dans un autre fichier
function add_in_file2($file, $file_tab){
	//global $file_tab;
	$fp = fopen($file,'a');
	foreach ($file_tab as $value){
		fputs($fp, $value);
	}
	fclose($fp);
	return true;
 }



//Créeer un fichier xml : 
#xml_file -> nom du fichier de sortie ie à créer
#xml_header -> Entête du fichier avec ouverture de la racine
#xml_content -> Contenu principal du fichier xml
#xml_footer -> fin de la racine

function create_xml($xml_file, $xml_header, $xml_content, $xml_footer){
	write_in_file($xml_file, $xml_header);
	add_in_file2($xml_file, $xml_content); // Lit à partir d'un tableau
	add_in_file($xml_file, $xml_footer);
	return true;
}

//Télécharger (upload) un fichier vers le serveur:
//Necessite de spécifier le chemin jusk'o dir ($path), 
//le nom du champ file ($filename), 
//le nom du fichier temporaire créé ($temp_filename) voir exemple dans PRFP
function upload_2_dir($path, $filename, $temp_filename){
		$uploaddir = $path;
		//$file = $filename;
		$result = move_uploaded_file($temp_filename, $uploaddir.$filename);
		return $result;
	}


//Parcourir un repertoire
function show_subdir($dir){
	if(is_dir($dir)){
		print "<a href=\"$dir\" onClick=\"".opendir($dir)."\">$dir</a><br />";
		return true;
	}
	else{
		return false;
	}
}

function browse_dir($dir){
	if(!is_dir($dir)){
		msgbox("$path n'est pas un nom de répertoire valide!");
		$returned_val = "false";
	}
	else{
		$folder = dir($dir);
		show_subdir($dir);
		while($file = $folder->read()){
			if(is_dir($file)){
				print "\n<a href='' onClick=".browse_dir($file).">$file</a>";
			}
			else{
				print "\n<a href=\"".$folder->path."/$file\">$file</a><br />";
			}
			
		}
		$folder->close();
		$returned_val = "true";
	}
	return $returned_val;
}

//Galérie d'images

function show_gallery($dir){
	$pix_xtensions = array("jpg", "gif", "png");
	if(is_dir($dir)){
		$folder = dir($dir);
		$i = 0;
		//Affiche tout le contenu du repertoire indexé
		while($file = $folder->read()){
		$i++;
			//N'affiche que les fichiers
			//if(is_file($file)){
				//if(in_array(filetype($file), $pix_extensions)){
					print "<a href=\"".$folder->path."/$file\" target=\"_blank\"><img width=\"100\" border=\"0\" src=\"".$folder->path."$file\" /></a><br />";
					print "$file<br />";
				//}
			//}
			//(is_file($file))? (print "<a href=\"".$folder->path."/$file\"><img src=\"".$folder->path.\" /></a>"):("");
			
		}
	}
	else{
			$dir = basename($dir);
			msgbox("$dir n'est pas un repertoire valide");
		}
}


function show_gallery2($dir){
	$pix_xtensions = array("jpg", "gif", "png");
	if(is_dir($dir)){
		$numImg = 0;
		$folder = dir($dir);
		//Affiche tout le contenu du repertoire indexé
		print "<SCRIPT LANGUAGE=\"JavaScript\">
				function replaceImg(NomImage) {
				document.MainImg.src = NomImage;
				}
				</script>";
		print "<table><tr>";
		while($file = $folder->read()){
			if(($file == "..") || ($file==".") || ($file=="Thumbs.db")) continue;
			else{
				$numImg++;
				// target=\"_blank\";
				print "<td><a href=javascript:replaceImg('".$folder->path."".$file."')><img width=\"75\" border=\"0\" src=\"".$folder->path."$file\" /></a></td>";
				br_reset2($numImg, 5);
			}
		}
		print "</tr></table>";
	}
	else{
			$dir = basename($dir);
			msgbox("$dir n'est pas un repertoire valide");
		}
}


/*******************************
*  Fonctions inhérentes à la protection des boîtes de saisie  *
********************************/
	function protect_box($box){
		$box = eregi_replace("<script"," ",nl2br($box));
		//$regs = array("
		return $box;
	}
           # Fonctoin en chantier
#Fin des fonctions [Protection des boîtes de saisie]

/*******************************
*  Fonctions inhérentes aux messages d'erreur
********************************/
	function file_size_error($file_size){
		$file_size = ($file_size / 1024);
		msgbox("Pas d'image ou image trop lourde!! Veuillez diminuer sa taille ou choisissez une autre image moins lourde");
	}


#Fin des fonctions [Messages d'erreur]

/************************************
*  Fonctions inhérentes aux casts  *
************************************/

function setNumber($number, $i=2, $default=""){
			if(($number=="")||($number==0)) 
				return $default;
			else
				return number_format($number, '$i', ',', ' ');
		}
#Fin des fonctions [de cast]

//Pour faire des chapeaux personnalisés
function chapo($string, $nb){
	if(strlen($string) > $nb){
		$new_string = substr($string, 0, $nb);
		$string = $new_string."...";
	}
	return $string;
}

//Utile pour la création des codes avec pseudos valeurs numériques 
function numParam($num){
	if($num<10) $numRet = "000".$num;
	if(($num>10) && ($num<100)) $numRet = "00".$num;
	if(($num>100) && ($num<1000)) $numRet = "0".$num;
	if(($num>1000) && ($num<10000)) $numRet = $num;
	return $numRet;
}

//recuperer la page précédente
function get_prevPage(){
	return $prev = $_SERVER['HTTP_REFERER'];
}

/*******************************
*  Fonctions inhérentes à XXX  *
********************************/
           # ...
#Fin des fonctions [XXX]

?>