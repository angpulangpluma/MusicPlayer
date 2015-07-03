<?php
    include("m3uexporter.php");
    include("v4_playlist_functions.php");
    include("playlist.database.php");

        // $request = $_SERVER['REQUEST_METHOD'] == 'POST' ? $_POST : $_GET;
        // print_r($_FILES); exit;
           // $request = $_GET;
        // print_r($request); exit;
        // switch($request['request']){
        // 	case 'save':
        // 		$file = trim($request['out']);
        // 		if($file!=""){
        //     		$exp = new m3uExporter($file);
        //             $files = array();
        //             foreach($request['song'] as $key => $song){
        //                 array_push($files, $request['song'][$key]);
        //             }
        //             // print_r($request['song']); exit;
        //     		$exp -> createFile($files);
        // 		}
        // 	break;
        //     case 'add':
            for($i=0; $i< count($_FILES); $i++){
                $name = $_FILES[$i]['name'];
                // echo $name."<br/>";
                $temp = $_FILES[$i]['tmp_name'];
                $ext       = ".".pathinfo($_FILES[$i]['name'], PATHINFO_EXTENSION);
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
                }//end else

                $url       = "../data/music/" . $new_name;
                $url2      = "data/music/" . $new_name;
                if(move_uploaded_file($temp, $url)){
                    if(pitem_add($new_name, $url, $url2)){

                    }//end inner if
                    
                }//end outer if
                
            }//end for
            header("../MusicPlayer.php");
        //     break;
        // }
    
?>