<?php require_once('../Connections/MyFileConnect.php'); ?>
<?php
	  require_once('../includes/db.php');
	  require("../src/inc/design.inc.php");
	  require("../src/inc/biblio.inc.php");
	  require("../src/inc/mysql_biblio.inc.php");
	  require("../src/inc/db.php");
	  require('../includes/MyFonction.php');


mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsUser = "SELECT * FROM users WHERE display = '1'";
$rsUser = mysql_query($query_rsUser, $MyFileConnect) or die(mysql_error());
$row_rsUser = mysql_fetch_assoc($rsUser);
$totalRows_rsUser = mysql_num_rows($rsUser);
$currentPage = $_SERVER["PHP_SELF"];

 do { 
 
    $date = date('Y-m-d H:i:s');
    $val1 = MinmapDB::getInstance()->get_user_date_last_login($row_rsUser['user_id']);
    $val2 = $date;
    
    $datetime1 = new DateTime($val1);
    $datetime2 = new DateTime($val2);
    
    $interval = date_diff($datetime1, $datetime2);
    
    if(($interval->format('%R%a')) > 30){
      MinmapDB::getInstance()->update_users_display($row_rsUser['user_id'], $date);
    } else {
      echo $interval->format('%R%a')."-".$row_rsUser['user_id'].";";
    }
    
 } while ($row_rsUser = mysql_fetch_assoc($rsUser)); 
 
 //$updateGoTo = "repcipm.php";
  $updateGoTo = "../user/UserDetails.php?menuID=3";
   if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));

  mysql_free_result($rsUser);
?>