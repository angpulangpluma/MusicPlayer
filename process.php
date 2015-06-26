<?php
include("m3uexporter.php");
    include("v4_playlist_functions.php");

        $request = $_SERVER['REQUEST_METHOD'] == 'POST' ? $_POST : $_GET;
        switch($request['request']){
        	case 'save':
        		$file = trim($request['out']);
        		$param;
        		if($file!=""){
            		$exp = new m3uExporter($file);
            		foreach($request['song'] as $song){
            			$param[] = trim($request['song']);
            		}
            		$exp -> createFile($request['song']);
        		}
        		die();
        		break;
        }
    
?>