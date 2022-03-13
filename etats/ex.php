<?php
require('mysql_table.php');
//require('../includes2/db.php');
$colname = $_REQUEST['bizRegNo'];

class PDF extends PDF_MySQL_Table
{
function Header()
{
	require('../includes2/db.php');
	$libValuename = $_REQUEST['comSig'];
	// Titre
	//$comissionLib = MinmapDB::getInstance()->get_lib_by_id(commissions, commission_lib, commission_id, $colname);
	//$comissionLib = MinmapDB::getInstance()->get_lib_by_id(structures, structure_lib, structure_id, $colname);
	//$comissionLib = 'Manger';
	// Logo
    $this->Image('../logo.png',10,6,30);
	$this->SetFont('Arial','',18);
	//$this->Cell(0,6,$libValuename,0,1,'C');
	$this->Cell(90,50,$libValuename,0,1,'C');
	$this->Ln(1);
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
    // Numero de page
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Connexion ?la base
$link = mysqli_connect('localhost:3301','root','','fichier_db');

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->AddCol('upper(personne_nom)',80,'NOM ET PRENOM');
$pdf->AddCol('upper(fonction_lib)',60,'FONCTION');
$pdf->AddCol('personne_telephone',40,'TELEPHONE');
// Premier tableau : imprime toutes les colonnes de la requete
$query_rsMembresCommission = sprintf("SELECT upper(personne_nom), upper(fonction_lib), personne_telephone FROM membres, commissions, personnes, fonctions WHERE membres.commissions_commission_id = commissions.commission_id   AND membres.personnes_personne_id = personnes.personne_id   AND membres.fonctions_fonction_id = fonctions.fonction_id   AND add_commission_agescom = 1  AND membres.display_agescom = 1 AND (type_commission_id = 1 OR type_commission_id = 3 OR type_commission_id = 4 OR type_commission_id = 7 OR type_commission_id = 8) AND commission_id = %s ORDER BY fonctions_fonction_id ASC", $colname);
//$query_rsMembresCommission = sprintf("select commissions_commission_id, fonctions_fonction_id, personnes_personne_id from membres where commissions_commission_id = %s ORDER BY fonctions_fonction_id ASC", $colname);
$pdf->Table($link,$query_rsMembresCommission);
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
