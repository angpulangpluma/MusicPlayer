<?php
	require_once("globals.php");
	require_once("class.database.php");
	$db = new Database("mysql", DBHOST, DBNAME, DBUSER, DBPASS);

	function pitem_add($name, $url, $url2){
		global $db;
			$sql = "INSERT INTO videos(name,url) VALUES(:name,:url)";
			$param = array(
				":name" => $name,
				":url" => $url
				);
			$res = $db->query("INSERT",$sql,$param);
			if($res['status']){
				return true;
			} else{
				return false;
			}
	}

	function pitem_get($name){
		global $db;

		$result = array(
			"err" => null,
			"exists" => false
			);

		$sql = "SELECT name, url from videos where name = :name or name like :name";
		$param = array(
			":name" => $name,
			":name" => $name."%"
			);
		// echo $sql;
		$ret = $db->query("SELECT",$sql,$param);
		// print_r($ret['count']);
		return $ret;
	}
?>