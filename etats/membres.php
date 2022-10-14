<?php
require('mysql_table.php');

//require('../includes2/db.php');
//$colname = $_REQUEST['bizRegNo'];
// Connexion ?la base
$link = mysqli_connect('localhost','root','','fichier_db8');

if (isset($_POST['value'])) {
  $colValue = $_POST['value'];
}
if (isset($_POST['regID'])) {
  $colregID = $_POST['regID'];
}
if (isset($_POST['depID'])) {
  $coldepID = $_POST['depID'];
}
if (isset($_POST['regVal'])) {
  $colregVal = $_POST['regVal'];
}
if (isset($_POST['depVal'])) {
  $coldepVal = $_POST['depVal'];
}
if (isset($_POST['typID'])) {
  $coltypID = $_POST['typID'];
}
if (isset($_POST['typM'])) {
  $coltypM = $_POST['typM'];
}

/*$colname_Recordset = "-1";
if (isset($_REQUEST['bizRegNo'])) {
  $colname_Recordset = $_REQUEST['bizRegNo'];
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_Recordset = sprintf("SELECT * FROM commissions WHERE commission_id = %s", $colname_Recordset);
$Recordset = mysql_query($query_Recordset, $MyFileConnect) or die(mysql_error());
$row_Recordset = mysql_fetch_assoc($Recordset);
$totalRows_Recordset = mysql_num_rows($Recordset);*/



class PDF extends PDF_MySQL_Table
{
function Header()
{
	//require('../includes2/db.php');
	require_once('../Connections/MyFileConnect.php');
	
	//$colregID=1;
	if (isset($_POST['regID']) && $_POST['regID'] != NULL ) {
	$colregID = $_POST['regID'];
	mysql_select_db($database_MyFileConnect, $MyFileConnect);
	$query_rsRegion = sprintf("SELECT region_id, region_lib FROM regions WHERE region_id = %s", $colregID);
	$rsRegion = mysql_query($query_rsRegion, $MyFileConnect) or die(mysql_error());
	$row_rsRegion = mysql_fetch_assoc($rsRegion);
	$totalRows_rsRegion = mysql_num_rows($rsRegion);
	}
	
	//$coldepID=1;
	if (isset($_POST['depID']) && $_POST['depID'] != NULL) {
	$coldepID = $_POST['depID'];
	mysql_select_db($database_MyFileConnect, $MyFileConnect);
	$query_rsDepartements = sprintf("SELECT departement_lib FROM departements WHERE departement_id = %s", $coldepID);
	$rsDepartements = mysql_query($query_rsDepartements, $MyFileConnect) or die(mysql_error());
	$row_rsDepartements = mysql_fetch_assoc($rsDepartements);
	$totalRows_rsDepartements = mysql_num_rows($rsDepartements);
	}
	$libValuename = $_REQUEST['comSig'];
	// requete 

	
	
	// Titre

    $this->Image('../logo.png',10,6,190);
	$this->SetFont('Arial','B',13);
	$this->Ln(35);// saut de page
	//$this->Cell(0,6,$libValuename,0,1,'C');
	$this->Cell(0,10,'MEMBRES DES COMMISSION DE PASSATION DES MARCHES PUBLICS',TB,1,'C');
	$this->Cell(0,10,'PRESIDENTS DE COMMISSION',0,1,'C');
	$this->Ln(5);
	$this->SetFont('Arial','I',12);
	//$h = 7;
	//$retrait "       ";
	
	$this->Write(7, '       Region :');		$this->Write(7, '   '.$row_rsRegion['region_lib']);
	$this->Ln(5);
	$this->Write(7, '       Departement :');	$this->Write(7, '   '.$row_rsDepartements['departement_lib']);
	$this->Ln(15);
	// Imprime l'en-t?e du tableau si n?essaire
	parent::Header();
	
}
// Pied de page
function Footer()
{
    // Positionnement a 1,5 cm du bas
    $this->SetY(-15);
    // Police Arial italique 8
    $this->SetFont('Arial','I',8);
	$this->Write(10,'Fichier des representants au sein des Comites et Commissions');
    // Numero de page
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}



$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->AddCol('upper(commission_sigle)',60,'COMITE/COMMISSION');
$pdf->AddCol('upper(personne_nom)',70,'NOM ET PRENOM');
$pdf->AddCol('sexe',60,'GENRE');

// Premier tableau : imprime toutes les colonnes de la requete

if (isset($_POST['value'])) {
  $colValue = $_POST['value'];
}
if (isset($_POST['regID'])) {
  $colregID = $_POST['regID'];
}
if (isset($_POST['depID'])) {
  $coldepID = $_POST['depID'];
}
if (isset($_POST['regVal'])) {
  $colregVal = $_POST['regVal'];
}
if (isset($_POST['depVal'])) {
  $coldepVal = $_POST['depVal'];
}
if (isset($_POST['typID'])) {
  $coltypID = $_POST['typID'];
}
if (isset($_POST['typM'])) {
  $coltypM = $_POST['typM'];
}
$txtSearch = isset($_POST['txtSearch'])?$_POST['txtSearch']:"-1";


$query_recordSetBasic = "SELECT membres.*, commission_id, commission_lib, upper(commission_sigle), personne_id, upper(personne_nom), personne_prenom, sexe, fonction_lib, personnes.structure_id, personne_telephone, fonctions.fonction_id, fonction_lib 
FROM membres, commissions, personnes, fonctions
WHERE membres.commissions_commission_id = commissions.commission_id  
AND membres.personnes_personne_id = personnes.personne_id  
AND membres.fonctions_fonction_id = fonctions.fonction_id  
AND add_commission_agescom = 1 
AND membres.display_agescom = 1";

	
	if (isset($colregID) && $colregID != NULL) {
		
		if (isset($coldepID) && $coldepID != NULL){	
		
			if (isset($coltypM) && $coltypM != NULL) {
				
			 			$query_recordSet = sprintf(" %s    
						AND region_id = %s
						AND departement_id = %s
						AND fonctions_fonction_id = %s 
						ORDER BY personne_nom, date_constation ASC", $query_recordSetBasic, $colregID, 
						$coldepID, $coltypM);
						
			} else {
						
						$query_recordSet = sprintf(" %s    
						AND region_id = %s
						AND departement_id = %s
						ORDER BY personne_nom, date_constation ASC", $query_recordSetBasic, $colregID, 
						$coldepID);								
				
			}
			
		} else {
			
			$query_recordSet = sprintf(" %s    
			AND region_id = %s
			ORDER BY personne_nom, date_constation ASC", $query_recordSetBasic, $colregID);
			
		}
		
	} else {
		
	   if (isset($colValue) && $colValue != NULL) {
		   
		   if (isset($coltypID) && $coltypID != NULL) {
			   
			   if (isset($colregVal) && $colregVal != NULL) {
		
					if (isset($coldepVal) && $coldepVal != NULL){
			   
					$query_recordSet = sprintf(" %s    
					AND fonctions_fonction_id = %s 
					AND type_commission_id = %s
					AND region_id = %s
					AND departement_id = %s
					ORDER BY personne_nom, date_constation ASC", $query_recordSetBasic, 
					$colValue, $coltypID, 
					$colregVal, $coldepVal);
				
		   			} else {
			   
					$query_recordSet = sprintf(" %s    
					AND fonctions_fonction_id = %s 
					AND type_commission_id = %s
					AND region_id = %s
					ORDER BY personne_nom, date_constation ASC", $query_recordSetBasic, 
					$colValue, $coltypID, 
					$colregVal);

		   			}
			   } else {
			   		$query_recordSet = sprintf(" %s    
					AND fonctions_fonction_id = %s 
					AND type_commission_id = %s
					ORDER BY personne_nom, date_constation ASC", $query_recordSetBasic, 
					$colValue, $coltypID);
			   }
		   } else {
		   	$query_recordSet = sprintf(" %s    
			AND fonctions_fonction_id = %s 
			ORDER BY personne_nom, date_constation ASC", $query_recordSetBasic, 
			$colValue);
		   }
		} else {
				$query_recordSet = sprintf(" %s  ORDER BY personne_nom ASC", $query_recordSetBasic);
		}
	
	}


$pdf->Table($link,$query_recordSet);
$pdf->SetFont('Arial','',13);
/*$pdf->AddPage();
// Second tableau : definit 3 colonnes
$pdf->AddCol('personne_nom',60,'Nom et Prenom','C');
$pdf->AddCol('fonction_lib',40,'Fonction');
$pdf->AddCol('personne_telephone',40,'Telephone','R');
$prop = array('HeaderColor'=>array(255,150,100),
			'color1'=>array(210,245,255),
			'color2'=>array(255,255,210),
			'padding'=>2);

$query_rsMembresCommission = sprintf("SELECT personne_nom, fonction_lib, personne_telephone FROM membres, commissions, personnes, fonctions WHERE membres.commissions_commission_id = commissions.commission_id   AND membres.personnes_personne_id = personnes.personne_id   AND membres.fonctions_fonction_id = fonctions.fonction_id   AND add_commission_agescom = 1  AND membres.display_agescom = 1 AND (type_commission_id = 1 OR type_commission_id = 3 OR type_commission_id = 4 OR type_commission_id = 7 OR type_commission_id = 8) AND commission_id = %s ORDER BY fonctions_fonction_id ASC", $colname);

$pdf->Table($link,$query_rsMembresCommission,$prop);*/
$pdf->Output();
?>
