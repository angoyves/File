<?php
require('mysql_table.php');
require('../Connections/MyFileConnect.php');

//$colname = $_REQUEST['bizRegNo'];
// Connexion ?la base
$link = mysqli_connect('localhost','root','','fichier_db8');

if (isset($_POST['bizRegNo'])) {
  $bizRegNo = $_POST['bizRegNo'];
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
	require('../includes/myFileDB.php');
	
	if (isset($_POST['bizRegNo'])) {
	  $bizRegNo = $_POST['bizRegNo'];
	}

	$commissionLib = myFileDB::getInstance()->getCommissionLibById($bizRegNo);
	//$commissionLib = getLibById(commissions, commission_lib, commision_id, $bizRegNo);
	// Titre
    $this->Image('../logo.png',10,6,190);
	$this->SetFont('Arial','B',13);
	$this->Ln(35);// saut de page
	//$this->Cell(0,6,$libValuename,0,1,'C');
	$this->Cell(0,10,'MEMBRES DES COMISTES ET COMMISSION DE PASSATION DES MARCHES PUBLICS',TB,1,'C');
	$this->Cell(0,10,'Numero:',0,1,'C');
	$this->Ln(5);
	$this->SetFont('Arial','I',12);
	//$h = 7;
	//$retrait "       ";
	
	//$this->Write(7, '       SIGLE :');		$this->Write(7, '   '.$commissionLib);
	$this->Ln(5);
	$this->Write(7, '       DESIGNATION :');	$this->Write(7, '   '.$commissionLib);
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
$pdf->AddCol('upper(personne_nom)',70,'NOM ET PRENOM');
$pdf->AddCol('fonction_lib',60,'FONCTION');
$pdf->AddCol('personne_telephone',60,'TELEPHONE');

// Premier tableau : imprime toutes les colonnes de la requete

/*$colname_rsMembresCommission = "-1";
if (isset($_REQUEST['bizRegNo'])) {
  $colname_rsMembresCommission = $_REQUEST['bizRegNo'];
}*/
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsMembresCommission = sprintf("SELECT personne_id, upper(personne_nom), personne_prenom, fonctions_fonction_id, fonction_lib, personnes.structure_id, personne_telephone   FROM membres, commissions, personnes, fonctions WHERE membres.commissions_commission_id = commissions.commission_id   AND membres.personnes_personne_id = personnes.personne_id   AND membres.fonctions_fonction_id = fonctions.fonction_id   AND add_commission_agescom = 1  AND membres.display_agescom = 1 AND (type_commission_id = 1 OR type_commission_id = 3 OR type_commission_id = 4 OR type_commission_id = 7 OR type_commission_id = 8) AND commission_id = %s ORDER BY fonctions_fonction_id ASC", $bizRegNo);
$rsMembresCommission = mysql_query($query_rsMembresCommission, $MyFileConnect) or die(mysql_error());
$row_rsMembresCommission = mysql_fetch_assoc($rsMembresCommission);
$totalRows_rsMembresCommission = mysql_num_rows($rsMembresCommission);

$pdf->Table($link,$query_rsMembresCommission);
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
