<?php
$colname_rsMenus = "-1";
if (isset($_SESSION['MM_UserGroup'])) {
  $colname_rsMenus = $_SESSION['MM_UserGroup'];
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsMenus = sprintf("SELECT * FROM menus WHERE user_groupe_id = %s OR  user_groupe_id = 0 AND display = 1 ORDER BY menu_id ASC", GetSQLValueString($colname_rsMenus, "int"));
$rsMenus = mysql_query($query_rsMenus, $MyFileConnect) or die(mysql_error());
$row_rsMenus = mysql_fetch_assoc($rsMenus);
$totalRows_rsMenus = mysql_num_rows($rsMenus);

$colname_rsSousMenu = "-1";
if (isset($_GET['menuID'])) {
  $colname_rsSousMenu = $_GET['menuID'];
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsSousMenu = sprintf("SELECT * FROM sous_menus WHERE menu_id = %s AND display = '1' ORDER BY position ASC", GetSQLValueString($colname_rsSousMenu, "int"));
$rsSousMenu = mysql_query($query_rsSousMenu, $MyFileConnect) or die(mysql_error());
$row_rsSousMenu = mysql_fetch_assoc($rsSousMenu);
$totalRows_rsSousMenu = mysql_num_rows($rsSousMenu);

$UserGroupe = (MinmapDB::getInstance()->get_user_groupe_by_user_login($_SESSION['MM_Username']));

?>