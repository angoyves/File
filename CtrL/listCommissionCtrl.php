<?php
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

$maxRows_Recordset = 10;
if (isset($_POST['recordCountPerPage'])) {
  $maxRows_Recordset = $_POST['recordCountPerPage'];
}
$pageNum_Recordset = 0;
if (isset($_GET['pageNum_Recordset'])) {
  $pageNum_Recordset = $_GET['pageNum_Recordset'];
}
$startRow_Recordset = $pageNum_Recordset * $maxRows_Recordset;

$colname_Recordset = "-1";
if (isset($_POST['commission_sigle'])) {
  $colname_Recordset = $_POST['commission_sigle'];
}
$colname_Recordset2 = "-1";
if (isset($_POST['commissionLib'])) {
  $colname_Recordset2 = $_POST['commissionLib'];
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);

if ((isset($_POST['commission_sigle']) && $_POST['commission_sigle']<>"") && (isset($_POST['commissionLib']) && $_POST['commissionLib']<>"")){
$query_Recordset = sprintf("SELECT * FROM commissions WHERE commission_sigle LIKE %s OR commission_lib LIKE %s ORDER BY commission_id DESC", GetSQLValueString("%" . $colname_Recordset . "%", "text"), GetSQLValueString("%" . $colname_Recordset2 . "%", "text"));
} else if ((isset($_POST['commission_sigle']) && $_POST['commission_sigle']<>"") && (isset($_POST['commissionLib']) && $_POST['commissionLib']=="")){
$query_Recordset = sprintf("SELECT * FROM commissions WHERE commission_sigle LIKE %s ORDER BY commission_id DESC", GetSQLValueString("%" . $colname_Recordset . "%", "text"));
} else if ((isset($_POST['commission_sigle']) && $_POST['commission_sigle']=="") && (isset($_POST['commissionLib']) && $_POST['commissionLib']<>"")){
$query_Recordset = sprintf("SELECT * FROM commissions WHERE commission_lib LIKE %s ORDER BY commission_id DESC", GetSQLValueString("%" . $colname_Recordset2 . "%", "text"));
} else {
$query_Recordset = "SELECT * FROM commissions WHERE display_agescom = '1' ORDER BY commission_id DESC";
}
$query_limit_Recordset = sprintf("%s LIMIT %d, %d", $query_Recordset, $startRow_Recordset, $maxRows_Recordset);
$Recordset = mysql_query($query_limit_Recordset, $MyFileConnect) or die(mysql_error());
$row_Recordset = mysql_fetch_assoc($Recordset);

if (isset($_GET['totalRows_Recordset'])) {
  $totalRows_Recordset = $_GET['totalRows_Recordset'];
} else {
  $all_Recordset = mysql_query($query_Recordset);
  $totalRows_Recordset = mysql_num_rows($all_Recordset);
}
$totalPages_Recordset = ceil($totalRows_Recordset/$maxRows_Recordset)-1;
?>