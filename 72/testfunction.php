<?php 

	  


    header("'Content-type: text/json'");

	$json_string = file_get_contents('./data.json');  

 	echo($json_string); 
 ?>