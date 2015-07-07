<?php
    include("m3uexporter.php");
    include("v4_playlist_functions.php");
    include("playlist.database.php");

        // $request = $_SERVER['REQUEST_METHOD'] == 'POST' ? $_POST : $_GET;
        // print_r($_FILES['files']); exit;
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
            for($i=0; $i< count($_FILES['files']['name']); $i++){
                //name contains the name of file to be uploaded e.g. music.mp3
                $name = $_FILES['files']['name'][$i];
                // echo $name."<br/>";
                //temp contains the actual location of the file to be uploaded e.g. c:/music/music.mp3
                $temp = $_FILES['files']['tmp_name'][$i];
                //ext contains the file type e.g. .mp3
                $ext       = ".".pathinfo($_FILES['files']['name'][$i], PATHINFO_EXTENSION);
                // echo $ext."<br/>";
                //base_name contains the file name without the extension e.g. music
                $base_name = str_replace($ext, "", $name);
                //new_name contains the file name to be inserted in the database
                $new_name  = "";
                //getting all the similar names from the database    
                $res = pitem_get($base_name);
                //checking if there is a similar name in the database
                if($res['count'] == 0 && file_exists($temp)){
                    //new_name will be the original name of the file e.g. music.mp3
                    $new_name  = $base_name . $ext;
                }else{
                    //new_name will a numbered version of the file depending of the number of files
                    //with a similar name e.g. music2.mp3
                    $new_name = $base_name . ($res['count'] + 1) . $ext;
                }//end else

                $url       = "../data/music/" . $new_name;
                $url2      = "data/music/" . $new_name;
                //move the file to data/music
                if(move_uploaded_file($temp, $url)){
                    //add the file to database
                    if(pitem_add($new_name, $url, $url2)){

                    }//end inner if
                    
                }//end outer if
                
            }//end for
            header("../MusicPlayer.php");
        //     break;
        // }
    
?>