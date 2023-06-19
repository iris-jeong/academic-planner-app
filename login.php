<?php
	require "config/config.php";
	//I. Is the user logged in?
	if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true ) {
		//1. User IS logged in; Redirect them to the home page.
		header('Location: schedule.php');
	} else {
		//2. User is NOT logged in.

		//a) Was there a form submission?
		if ( isset($_POST['email']) && isset($_POST['password']) ) {
			
			//i) The form was submitted; Do form validation.
			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

			if($mysqli->connect_errno) {
				echo $mysqli->connect_error;
				exit();
			}

			$email = $_POST['email'];
			$password = $_POST['password'];

			$email = $mysqli->escape_string($email);
			$password = $mysqli->escape_string($password);

			$password = hash('sha256', $password);

			$sql = "SELECT * 
					FROM users
					WHERE email = '$email'
					AND password = '$password';";

			$results = $mysqli->query($sql);
			
			// echo "<pre>";
			// echo $result['first_name'];
			// echo $result['last_name'];
			// echo $result['major_id'];
			// echo "</pre>";

			if (!$results) {
				echo $mysqli->error;
				$mysqli->close();
				exit();
			}

			$mysqli->close();

			if ( $results->num_rows == 1 ) {
				// Valid credentials.
				$user = $results->fetch_assoc();
				$_SESSION['logged_in'] = true;
				$_SESSION['user_id'] = $user['id'];
				$_SESSION['email'] = $user['email'];
				$_SESSION['first_name'] = $user['first_name'];
				$_SESSION['last_name'] = $user['last_name'];
				$_SESSION['major_id'] = $user['major_id'];
				$_SESSION['minor_id'] = $user['minor_id'];

				header('Location: schedule.php');

			} else {
				// Invalid credentials.
				$error = "Invalid credentials.";

			}
		}
			//ii) No form submission; Just show the form.
	}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Login</title>

		<link
			rel="stylesheet"
			href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
		/>
		<style>
			body {
				min-height: 100vh;
				margin-left: 0;
				color: #4c4c4c;
			}
			form {
				border-radius: 15px;
			}
		</style>
	</head>
	<body class="d-flex align-items-center">
		<div class="container d-flex justify-content-center">
			<form action="login.php" method="POST" class="shadow pl-5 pr-5 pb-5 pt-5 w-50">
				<div class="d-flex flex-wrap justify-content-center mb-3">
					<h1>Welcome, Student.</h1>
					<p class="text-muted">Log in to access your account.</p>
				</div>
				
				<div class="row mb-3">
					<div class="font-italic text-danger ml-sm-auto">
						<!-- Show errors here. -->
						<?php
							if ( !empty($error) ) {
								echo $error;
							}
						?>
					</div>
				</div> <!-- .row -->

				<div class="form-group">
					<label for="email">Email address</label>
					<input
						type="email"
						class="form-control"
						id="email"
						name="email"
						aria-describedby="emailHelp"
						placeholder="Enter email"
					/>
					<small id="email-error" class="invalid-feedback">Email is required.</small>
				</div>
				<div class="form-group mb-4">
					<div class="d-flex justify-content-between">
						<label for="password">Password</label>
						<a class="" href="password.php">Forgot Password?</a>
					</div>
					<input
						type="password"
						class="form-control"
						id="password"
						name="password"
						placeholder="Enter password"
					/>
					<small id="password-error" class="invalid-feedback">Password is required.</small>
				</div>
				<br />
			
				<button class="btn btn-primary btn-block">Log in</button>
				
				<br />
				<div class="mt-4 d-flex justify-content-center">
					<span class="mr-2">Don't have an account?</span>
					<a href="register.php">Register here.</a>
				</div>
			</form>
		</div>

		<!-- ------------------------- SCRIPTS ----------------------------- -->
		<?php include "config/scripts.html" ?>
		<script>
		document.querySelector('form').onsubmit = function(){
			if ( document.querySelector('#email').value.trim().length == 0 ) {
				document.querySelector('#email').classList.add('is-invalid');
			} else {
				document.querySelector('#email').classList.remove('is-invalid');
			}

			if ( document.querySelector('#password').value.trim().length == 0 ) {
				document.querySelector('#password').classList.add('is-invalid');
			} else {
				document.querySelector('#password').classList.remove('is-invalid');
			}

			return ( !document.querySelectorAll('.is-invalid').length > 0 );
		}
	</script>
	</body>
</html>
