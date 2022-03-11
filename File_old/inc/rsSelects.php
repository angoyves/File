<?php 
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsLocalites = "SELECT localite_id, localite_lib FROM localites WHERE display = '1' ORDER BY localite_lib ASC";
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

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsStructures = "SELECT structure_id, structure_lib FROM structures WHERE display = '1' ORDER BY structure_lib ASC";
$rsStructures = mysql_query($query_rsStructures, $MyFileConnect) or die(mysql_error());
$row_rsStructures = mysql_fetch_assoc($rsStructures);
$totalRows_rsStructures = mysql_num_rows($rsStructures);

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsRegion = "SELECT region_id, region_lib FROM regions WHERE display = '1' ORDER BY region_lib ASC";
$rsRegion = mysql_query($query_rsRegion, $MyFileConnect) or die(mysql_error());
$row_rsRegion = mysql_fetch_assoc($rsRegion);
$totalRows_rsRegion = mysql_num_rows($rsRegion);

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsTypelocalites = "SELECT type_localite_id, type_localite_lib FROM type_localites WHERE display = '1' ORDER BY type_localite_lib ASC";
$rsTypelocalites = mysql_query($query_rsTypelocalites, $MyFileConnect) or die(mysql_error());
$row_rsTypelocalites = mysql_fetch_assoc($rsTypelocalites);
$totalRows_rsTypelocalites = mysql_num_rows($rsTypelocalites);
?>