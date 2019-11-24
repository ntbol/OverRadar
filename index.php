<?php
	
	

?>
<!DOCTYPE html>
<html>
<head>
	<title>Test</title>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<link rel="stylesheet" href="css/styles.css" type="text/css">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">

</head>
<body>
<div id="header">
	<div id="wrap" align="center">
		<div class="container">
			<h1 class="title">Over<span style="color:#FA9C1D">Radar</span></h1>
			<h3>Live Updated Overwatch Stats</h3>
			<form method="get" action="profile.php">

				<input type="text" name="username" placeholder="Username" class="form-style">
				<input type="text" name="id" placeholder="Battle.Net #" class="form-style">
				<select name="platform" class="form-style">
				    <option value="pc">PC</option>
				    <option value="xbox">Xbox</option>
				    <option value="ps4">PS4</option>
				    <option value="switch">Switch</option>
				 </select>
				 <select name="region" class="form-style">
				    <option value="us">US</option>
				    <option value="eu">EU</option>
				    <option value="asia">Asia</option>
				 </select>
				 <button type="submit" class="form-button"><span class="fas fa-search"></span></button>

			</form>
		</div>
	</div>
</div>

</body>
</html>