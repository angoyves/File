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

/*if (!function_exists("GetSQLQueryString")) {
function GetSQLQueryString($query_recordSetBasic, $coltypID_fonction, $colregID_fonction, $coldepID_fonction){ 
if (isset($coltypID_fonction)){
		if (isset($colregID_fonction)){
			if (isset($coldepID_fonction)){
			$query_recordSet = sprintf(" %s   
				AND fonctions_fonction_id = %s 
				AND type_commission_id = %s
				AND region_id = %s
				AND departement_id = %s
				ORDER BY personne_nom, date_constation ASC", $query_recordSetBasic, GetSQLValueString($colValue_fonction, "int"), GetSQLValueString($coltypID_fonction, "int"), GetSQLValueString($colregID_fonction, "int"), GetSQLValueString($coldepID_fonction, "int"));
			} else {
		$query_recordSet = sprintf(" %s
		AND fonctions_fonction_id = %s 
		AND type_commission_id = %s
		AND region_id = %s
		ORDER BY date_constation, personne_nom ASC", $query_recordSetBasic, GetSQLValueString($colValue_fonction, "int"), GetSQLValueString($coltypID_fonction, "int"), GetSQLValueString($colregID_fonction, "int")); }
		} 
	}
}*/

?>