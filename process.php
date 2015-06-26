<?php
include("m3uexporter.php");
    include("v4_playlist_functions.php");

        $request = $_SERVER['REQUEST_METHOD'] == 'POST' ? $_POST : $_GET;
        #print_r($request);
        switch($request['request']){
        	case 'save':
        		$file = trim($request['out']);
        		if($file!=""){
            		$exp = new m3uExporter($file);
            		$exp -> createFile($request['song']);
        		}
        		die();
        		break;
        }
    
?>