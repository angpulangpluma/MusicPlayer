<?php

	include("m3uexporter.php");
    include("v4_playlist_functions.php");
    include("playlist.database.php");

        // $request = $_SERVER['REQUEST_METHOD'] == 'POST' ? $_POST : $_GET;
           // $request = $_GET;
    		  // print_r($_FILES); exit;
           // print_r($_GET['file']);
           $file = explode(",", $request['file']);
           // print_r($file); exit;
           // echo sizeof($file); exit;
           for($i=0;$i<sizeof($file);$i++){
           		// echo $file[$i] . "\n";
           		$ext = ".".pathinfo($file[$i], PATHINFO_EXTENSION);
           		$temp = $_FILES['file']['tmp_name'][$i];
           		// echo $a;
           		$base_name = str_replace($ext, "", $file[$i]);
           		$new_name = "";
           		$res = pitem_get($base_name);
           		if($res['count']==0){
           			$new_name = $base_name . $ext;
           		} else{
           			$new_name = $base_name . ($res['count'] + 1) . $ext;
           		}

           		$url = "../data/music/" . $new_name;
           		$url2 = "data/music/" . $new_name;

           		if(move_uploaded_file($temp, $url)){
           			if(pitem_add($new_name, $url, $url2)){

           			}//inner if
           		}//outer if
           }//end for

           header("../MusicPlayer.php");

?>