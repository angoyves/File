<?php 
$colname_rsLocalites = "-1";
if (isset($_GET['depID'])) {
  $colname_rsLocalites = (get_magic_quotes_gpc()) ? $_GET['depID'] : addslashes($_GET['depID']);
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsLocalites = sprintf("SELECT localite_id, localite_lib FROM localites WHERE departement_id = %s AND display = 1 ORDER BY localite_lib ASC", $colname_rsLocalites);
$rsLocalites = mysql_query($query_rsLocalites, $MyFileConnect) or die(mysql_error());
$row_rsLocalites = mysql_fetch_assoc($rsLocalites);
$totalRows_rsLocalites = mysql_num_rows($rsLocalites);

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsTypeCommission = "SELECT type_commission_id, type_commission_lib FROM type_commissions WHERE display = '1' ORDER BY type_commission_lib ASC";
$rsTypeCommission = mysql_query($query_rsTypeCommission, $MyFileConnect) or die(mysql_error());
$row_rsTypeCommission = mysql_fetch_assoc($rsTypeCommission);
$totalRows_rsTypeCommission = mysql_num_rows($rsTypeCommission);

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsNatureCommission = "SELECT nature_id, lib_nature FROM natures WHERE display = '1' ORDER BY lib_nature ASC";
$rsNatureCommission = mysql_query($query_rsNatureCommission, $MyFileConnect) or die(mysql_error());
$row_rsNatureCommission = mysql_fetch_assoc($rsNatureCommission);
$totalRows_rsNatureCommission = mysql_num_rows($rsNatureCommission);

/*mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsStructures = "SELECT structure_id, structure_lib FROM structures WHERE type_structure_id =4 AND display = '1' ORDER BY structure_lib ASC";
$rsStructures = mysql_query($query_rsStructures, $MyFileConnect) or die(mysql_error());
$row_rsStructures = mysql_fetch_assoc($rsStructures);
$totalRows_rsStructures = mysql_num_rows($rsStructures);*/


$colname_rsStructures = isset($_REQUEST["locID"])?$_REQUEST["locID"]:"79";

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsStructures = sprintf("SELECT structure_id, structure_lib, code_structure FROM structures WHERE localite_id = %s AND display_agescom = 1 ORDER BY code_structure ASC", $colname_rsStructures);
$rsStructures = mysql_query($query_rsStructures, $MyFileConnect) or die(mysql_error());
$row_rsStructures = mysql_fetch_assoc($rsStructures);
$totalRows_rsStructures = mysql_num_rows($rsStructures);

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsRegion = "SELECT region_id, region_lib FROM regions WHERE display = '1' ORDER BY region_lib ASC";
$rsRegion = mysql_query($query_rsRegion, $MyFileConnect) or die(mysql_error());
$row_rsRegion = mysql_fetch_assoc($rsRegion);
$totalRows_rsRegion = mysql_num_rows($rsRegion);

$colname_rsDepartements = "-1";
if (isset($_GET['regID'])) {
  $colname_rsDepartements = (get_magic_quotes_gpc()) ? $_GET['regID'] : addslashes($_GET['regID']);
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsDepartements = sprintf("SELECT * FROM departements WHERE regions_region_id = %s AND display = 1 ORDER BY departement_lib ASC", $colname_rsDepartements);
$rsDepartements = mysql_query($query_rsDepartements, $MyFileConnect) or die(mysql_error());
$row_rsDepartements = mysql_fetch_assoc($rsDepartements);
$totalRows_rsDepartements = mysql_num_rows($rsDepartements);
?>