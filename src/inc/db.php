<?php
$date = date('Y-m-d H:i:s');
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_RsMois = "SELECT * FROM mois";
$RsMois = mysql_query($query_RsMois, $MyFileConnect) or die(mysql_error());
$row_RsMois = mysql_fetch_assoc($RsMois);
$totalRows_RsMois = mysql_num_rows($RsMois);

mysql_free_result($RsMois);
?>
