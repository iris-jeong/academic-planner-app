<?php
require 'config/config.php';
//Form validation.
if ( !isset($_POST['first_name']) || trim($_POST['first_name'] == '')
    || !isset($_POST['last_name']) || trim($_POST['last_name'] == '')
    || !isset($_POST['email']) || trim($_POST['email'] == '')
	|| !isset($_POST['password']) || trim($_POST['password'] == '')
    || !isset($_POST['major_id']) || trim($_POST['major_id'] == '') ) {
	$error = "Please fill out all required fields.";
} else {
	// All required fields were provided.
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}

	$email = $_POST['email'];
	$password = $_POST['password'];
    $major = $_POST['major_id'];
	$fname = $_POST['first_name'];
	$lname = $_POST['last_name'];

	$email = $mysqli->escape_string($email);
	$password = $mysqli->escape_string($password);
    $major = $mysqli->escape_string($major);
    $fname = $mysqli->escape_string($fname);
    $lname = $mysqli->escape_string($lname);
    
	$password = hash('sha256', $password);

	$sql_registered = "SELECT * 
						FROM users
						WHERE email = '$email';";

	$results_registered = $mysqli->query($sql_registered);

	if (!$results_registered) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}			
	
	if ($results_registered->num_rows > 0) {
		$error = "Username or email already registered.";
	} else {
        if ( isset($_POST['minor_id']) && trim($_POST['minor_id']) != '' ) {
            $minor = $_POST['minor_id'];
        } else {
            $minor = "null";
        }

		$sql = "INSERT INTO users (email, password, major_id, minor_id, first_name, last_name)
					VALUES ('$email', '$password', $major, $minor, '$fname', '$lname');";

		// echo "<hr>$sql<hr>";

		$results = $mysqli->query($sql);

		if (!$results) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}
	}

	$mysqli->close();
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Registration Confirmation | Song Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">User Registration</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

		<div class="row mt-4">
			<div class="col-12">
				<?php if ( isset($error) && trim($error) != '' ) : ?>
					<div class="text-danger"><?php echo $error; ?></div>
				<?php else : ?>
					<div class="text-success"><?php echo $email; ?> was successfully registered.</div>
				<?php endif; ?>
		</div> <!-- .col -->
	    </div> <!-- .row -->

        <div class="row mt-4 mb-4">
            <div class="col-12">
                <a href="login.php" role="button" class="btn btn-primary">Login</a>
                <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-light">Back</a>
            </div> <!-- .col -->
        </div> <!-- .row -->

    </div> <!-- .container -->

    <!-- ------------------------- SCRIPTS ----------------------------- -->
    <?php include "config/scripts.html" ?>
</body>
</html>