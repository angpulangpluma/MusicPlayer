<?php
 $sandbox = false;

 if($sandbox === true){
 	define("DBUSER", "root");
		define("DBPASS", "admin");
		define("DBNAME", "videoplayer");
		define("DBHOST", "localhost");
 } else{
 	define("DBUSER", "root");
		define("DBPASS", "");
		define("DBNAME", "videoplayer");
		define("DBHOST", "localhost");
 }
?>