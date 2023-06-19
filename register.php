<?php
	//Output all the majors and minors from the database.
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Register</title>

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
			.slant1 {
				display: block;
			}
		</style>
	</head>
	<body class="d-flex align-items-center">
		<div class="slant-container">
			<div class="slant1"></div>
			<div class="slant2"></div>
			<div class="slant3"></div>
			<div class="slant4"></div>
		</div>
		<div class="container d-flex justify-content-center">
			<form action="register_confirmation.php" method="POST" class="form shadow pl-5 pr-5 pb-5 pt-5 w-50">
				<div class="d-flex flex-wrap justify-content-center mb-3">
					<h1>Register</h1>
					<p class="text-muted">
						Enter your information to create an account.
					</p>
				</div>
				<div class="form-group">
					<label for="firstName">First name</label>
					<span class="text-danger">*</span>
					<input
						type="text"
						class="form-control"
						id="firstName"
						name="first_name"
						aria-describedby="firstNameHelp"
						placeholder=""
					/>
				</div>
				<div class="form-group">
					<label for="lastName">Last name</label>
					<span class="text-danger">*</span>
					<input
						type="text"
						class="form-control"
						id="lastName"
						name="last_name"
						aria-describedby="lastNameHelp"
						placeholder=""
					/>
				</div>
				<div class="form-group">
					<label for="email">Email address</label>
					<span class="text-danger">*</span>
					<input
						type="email"
						class="form-control"
						id="email"
						name="email"
						aria-describedby="emailHelp"
						placeholder=""
					/>
				</div>
				<div class="form-group mb-4">
					<label for="password">Password </label
					><span class="text-danger"> *</span>
					<input
						type="password"
						class="form-control"
						id="password"
						name="password"
						placeholder=""
					/>
				</div>

				<div class="d-flex justify-content-between">
					<div class="form-group">
						<label for="major">Major</label
						><span class="text-danger"> *</span>
						<select class="form-control" name="major_id" id="major">
							<option value="" selected>
								--Select a Major--
							</option>
							<option value="2">Cognitive Science</option>
							<option value="4">Computer Science</option>
							<option value="5">Psychology</option>
						</select>
					</div>
					<div class="form-group ml-3">
						<label for="minor">Minor</label>
						<select class="form-control" name="minor_id" id="minor">
							<option value="" selected>
								--Select a Minor--
							</option>
							<option value="6">
								Web Technologies & Applications
							</option>
						</select>
					</div>
				</div>
				<br />

				<button class="btn btn-primary btn-block">Register</button>
				<br />
				<div class="mt-4 d-flex justify-content-center">
					<span class="mr-2">Already have an account?</span>
					<a href="login.php">Login here.</a>
				</div>
			</form>
		</div>

		<!-- ------------------------- SCRIPTS ----------------------------- -->
        <?php include "config/scripts.html" ?>
		<script>
		document.querySelector('form').onsubmit = function(){
			if ( document.querySelector('#firstName').value.trim().length == 0 ) {
				document.querySelector('#firstName').classList.add('is-invalid');
			} else {
				document.querySelector('#firstName').classList.remove('is-invalid');
			}

			if ( document.querySelector('#lastName').value.trim().length == 0 ) {
				document.querySelector('#lastName').classList.add('is-invalid');
			} else {
				document.querySelector('#lastName').classList.remove('is-invalid');
			}

			if ( document.querySelector('#email').value.trim().length == 0 ) {
				document.querySelector('#email').classList.add('is-invalid');
			} else {
				document.querySelector('#email').classList.remove('is-invalid');
			}

			if ( document.querySelector('#major').value.trim().length == 0 ) {
				document.querySelector('#major').classList.add('is-invalid');
			} else {
				document.querySelector('#major').classList.remove('is-invalid');
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
