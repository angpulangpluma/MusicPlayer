<?php
	//globals.php includes values for DBHOST, DBNAME, DBUSER, DBPASS
	require_once("globals.php");
	//class.database.php includes PDO functions
	require_once("class.database.php");
	//initializes database using PDO construct in class.database
	$db = new Database("mysql", DBHOST, DBNAME, DBUSER, DBPASS);


	//pitem_add(3) adds an uploaded music file in the database.
	//@param name - name of music file
	//@param url, url2 - location of music file
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

	//pitem_get(1) returns an array of uploaded music files
	//@param name - string of array to be searched
	//@return result of query
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