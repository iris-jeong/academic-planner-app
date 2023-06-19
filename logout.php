<?php
	session_start();
	session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Logout</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4 mb-4">Logout</h1>
			<div class="col-12">You are now logged out.</div>
			<div class="col-12 mt-3">Go back to <a href="login.php">log in</a>.</div>
		</div> <!-- .row -->
	</div> <!-- .container -->

</body>
</html>