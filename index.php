<?php 

?>
<html>
<head>
	<title></title>
</head>
<body>

	<!--<form action="index.php" method="POST" enctype="multipart/form-data">-->
	<form action="includes/process.php" method="POST" enctype="multipart/form-data">		
	<input type="file" name="file[]" multiple/>
	<input type="hidden" name="request" value="upload"/>
	<input type="submit" name="submit" value="Upload" />

	</form><br><br>

	<?php

		if (isset($_POST['submit'])) {
		 	echo $name . " has been uploaded!";
		 } 

	?>

</body>
</html>