<?php
require('mysql_table.php');

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
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
}

class PDF extends PDF_MySQL_Table
{
function Header()
{
	// Titre
	$this->SetFont('Arial','',18);
	$this->Cell(0,6,'Populations mondiales',0,1,'C');
	$this->Ln(10);
	// Imprime l'en-t?e du tableau si n?essaire
	parent::Header();
}
}

// Connexion ?la base
$link = mysqli_connect('localhost','root','','fichier_db8');
$colname = $_REQUEST['bizRegNo'];

$pdf = new PDF();
$pdf->AddPage();
// Premier tableau : imprime toutes les colonnes de la requete
$pdf->Table($link,'select commissions_commission_id, fonctions_fonction_id, personnes_personne_id from membres order by commissions_commission_id');
$pdf->AddPage();
// Second tableau : definit 3 colonnes
$pdf->AddCol('commissions_commission_id',20,'Commission Id','C');
$pdf->AddCol('fonctions_fonction_id',40,'fonction Id');
$pdf->AddCol('personnes_personne_id',40,'Personne Id','R');
$prop = array('HeaderColor'=>array(255,150,100),
			'color1'=>array(210,245,255),
			'color2'=>array(255,255,210),
			'padding'=>2);

$query_rsMembresCommission = sprintf("SELECT personne_nom, fonction_lib, personne_telephone FROM membres, commissions, personnes, fonctions WHERE membres.commissions_commission_id = commissions.commission_id   AND membres.personnes_personne_id = personnes.personne_id   AND membres.fonctions_fonction_id = fonctions.fonction_id   AND add_commission_agescom = 1  AND membres.display_agescom = 1 AND (type_commission_id = 1 OR type_commission_id = 3 OR type_commission_id = 4 OR type_commission_id = 7 OR type_commission_id = 8) AND commission_id = %s ORDER BY fonctions_fonction_id ASC", GetSQLValueString($colname, "int"));

$pdf->Table($link,$query_rsMembresCommission,$prop);
$pdf->Output();
?>
