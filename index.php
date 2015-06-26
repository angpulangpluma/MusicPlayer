<?php 

mysql_connect("127.0.0.1", "root", "");
mysql_select_db("videoplayer");

if (isset($_POST['submit'])) {
	
	$name = $_FILES['file']['name'];
	$temp = $_FILES['file']['tmp_name'];

	move_uploaded_file($temp, "uploaded/" . $name);
	$url = "http://localhost/htdocs/VideoPlayer/uploaded/$name";
	mysql_query("INSERT INTO 'videos' VALUE ('','$name','$url');");

}

?>
<html>
<head>
	<title></title>
</head>
<body>

	<form action="index.php" method="POST" enctype="multipart/form-data">
		
	<input type="file" name="file" />
	<input type="submit" name="submit" value="Upload" />

	</form><br><br>

	<?php

		if (isset($_POST['submit'])) {
		 	echo $name . " has been uploaded!";
		 } 

	?>

</body>
</html>