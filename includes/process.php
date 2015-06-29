<?php
    include("m3uexporter.php");
    include("v4_playlist_functions.php");
    include("playlist.database.php");

        $request = $_SERVER['REQUEST_METHOD'] == 'POST' ? $_POST : $_GET;
        // print_r($request);
        switch($request['request']){
        	case 'save':
        		$file = trim($request['out']);
        		if($file!=""){
            		$exp = new m3uExporter($file);
            		$exp -> createFile($request['song']);
        		}
        	break;
            case 'add':
            for($i=0; $i< count($_FILES['file']['name']); $i++){
                $name = $_FILES['file']['name'][$i];
                // echo $name."<br/>";
                $temp = $_FILES['file']['tmp_name'][$i];
                $ext       = ".".pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION);
                // echo $ext."<br/>";
                $base_name = str_replace($ext, "", $name);
                // echo $base_name."<br/>";
                $new_name  = "";    
                $res = pitem_get($base_name);#exit;
                if($res['count'] == 0){
                    $new_name  = $base_name . $ext;
                }else{
                    // $new_name = substr($base_name,0, -1) . ($res['count'] + 1) . $ext;
                    $new_name = $base_name . ($res['count'] + 1) . $ext;
                    // echo $new_name."<br/>";
                    // print_r($res['data']);
                    // echo ($res['count']+1);exit;
                }

                $url       = "../data/music/" . $new_name;
                $url2      = "data/music/" . $new_name;
                if(move_uploaded_file($temp, $url)){
                    if(pitem_add($new_name, $url, $url2)){
                        // return true;
                    }
                    // return false;
                }
                // return false;
            }
            break;
        }
    
?>