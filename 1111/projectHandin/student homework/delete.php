<?php

 include '../connect_database.php';
$con2="DELETE FROM $_homework where filename='' and size='0.00 Kb'";
mysql_query($con2,$link) or die(mysql_error());

?>