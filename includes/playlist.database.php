<?php
	require_once("globals.php");
	require_once("class.database.php");
	$db = new Database("mysql", DBHOST, DBNAME, DBUSER, DBPASS);

	function pitem_add($name, $temp){
		global $db;

		$ret = pitem_get($name);
		if($ret['exists']){
			return false;
		} else{
			move_uploaded_file($temp, "data/".$name);
			$url = "http://localhost/htdocs/MusicPlayer/data/$name";
			$sql = "INSERT INTO videos(id,name,url) VALUES('',:name,:url)";
			$param = array(
				":name" => $name;
				":url" => $url;
				);
			$res = $db->query("INSERT",$sql,$param);
			if($res['status']){
				return true;
			} else{
				return null;
			}
		}

		$query = ""
	}

	function pitem_get($name){
		global $db;

		$result = array(
			"err" => null,
			"exists" => false
			);

		$sql = "SELECT name, url from 'videos where name = :name";
		$param = array(
			":name" => $name
			);

		$ret = $db->query("SELECT",$sql,$param);

		if($ret['status']){
			if($ret['count'] > 0){
				$result['name'] = $ret['data'][0]['name'];
				$result['url'] = $ret['data'][0]['url'];
				$result['exists'] = true;
			} else{
				$result['err'] = "File not found".
			}
		}else{
			$result['err'] = "SQL Error";
		}

		return $result;
	}
?>