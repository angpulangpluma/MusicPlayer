<?php
/*
* @author: Marienne Lopez
* @filename: playlist_functions.php
* @desc: functions that have anything to do with loading and unloading a playlist.
* @sources: m3u.class.php provided by Robert Widdick and writing to m3u file by https://github.com/ChoiZ/php-playlist-generator/blob/master/generate.php
*/

class m3uExporter {

	private $file;

	public function __construct($filename){
		if(!empty($filename)){
			$file = new stdClass;
			$file->name = $filename;
			header('Content-Type: audio/mpeg, audio/mp3, audio/x-mpeg, audio/x-mpeg-3');
			header('Content-Disposition: attachment; filename='.$file->name.'.'.'m3u');
		} else die("Cannot create file without filename.");
	}

	public function createFile($sloc){
		if(!empty($sloc)){
			if(is_array($sloc) && count($sloc) > 0){
				foreach ($sloc as $loc){
					echo "\n".$loc;
				}
			} else{
				echo "\n".$sloc;
			}
		} else die("Will not create file because information is missing.");
	}
}

#$m3uExp = new m3uExporter("test");

#echo $m3uExp -> createFile(array("C:\Users\YING LOPEZ\Music\..\Downloads\A-RISE - Private Wars (full).mp3",
#"C:\Users\YING LOPEZ\Music\..\Downloads\A-RISE - Shocking Party (Full).mp3",
#"C:\Users\YING LOPEZ\Music\..\Downloads\Shocking Party Instrumental- A RISE (Love Live!).mp3
#"));

#echo $m3uExp -> createFile("C:\Users\YING LOPEZ\Music\..\Downloads\A-RISE - Private Wars (full).mp3");

?>