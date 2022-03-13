<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_MyFileConnect = "localhost";
$database_MyFileConnect = "fichier_db";
$username_MyFileConnect = "root";
$password_MyFileConnect = "";
$MyFileConnect = mysql_pconnect($hostname_MyFileConnect, $username_MyFileConnect, $password_MyFileConnect) or trigger_error(mysql_error(),E_USER_ERROR); 
?>