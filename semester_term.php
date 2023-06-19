<?php
	require "config/config.php";
	//1. Establish MySQL Connection.
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	//a) Check for connection errors.
	if($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}
	//2. Submit SQL Statement.
	//a) Write the SQL statement; Retrieve semester names from semesters
	$sql_semesters = "SELECT * FROM semesters;";
	//b) Make the query.
	$semesters = $mysqli->query($sql_semesters);
	//c) Check for errors.
	if(!$semesters) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	//3. Close DB Connection.
	$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Add New</title>
		<?php include "config/css.html" ?>
		<link rel="stylesheet" href="css/semester_term.css" />
	</head>
	<body>
		<div class="main-container">
		<?php include "config/nav.php" ?>

			<div class="content">
				<div class="content-child">
					<div class="header">
						<h1>Choose a term</h1>
					</div>
					<!-- .header-->
					<div class="body">
						<form method="POST" action="semester_year.php" id="radio-cards-container">
                                <?php while( $row = $semesters->fetch_assoc()) : ?>
									<div class="col-md-4 col-lg-4 col-sm-4">
										
										<label>
											<?php if($row['name'] == "Summer") : ?>
											
												<input type="radio" name="term" class="card-input-element" value="<?php echo $row['name']?>" checked/>

												<div class="panel panel-default card-input">
													<div class="panel-body">
														<?php echo $row['name']; ?>
													</div>
												</div>
											<?php else : ?>
												<input type="radio" name="term" class="card-input-element" value="<?php echo $row['name']?>"/>

												<div class="panel panel-default card-input">
													<div class="panel-body">
														<?php echo $row['name']; ?>
													</div>
												</div>
											<?php endif; ?>

										</label>

									</div>
								<?php endwhile; ?>
                            <div class="btn-container">
								<button class="next-btn" type="submit">Next</button>
							</div>
						</form>
						<!-- .radio-cards-container -->
					</div>
					<!-- .body -->
					<div class="footer">
						<div class="bottom-nav-container">
							<div>
								<!-- <a class="buttons" href="semester_year.php"
									>Next</a
								> -->
							</div>
						</div>
						<!-- .bottom-nav -->
					</div>
					<!-- .footer -->
				</div>
				<!-- .content-child -->
			</div>
			<!-- .content -->
		</div>
		<!-- .main-container -->
		<!-- ------------------------- SCRIPTS ----------------------------- -->
        <?php include "config/scripts.html" ?>
		<script>
		document.querySelector('form').onsubmit = function(){
			let inputs = document.querySelectorAll(input);

			if()
		}
	</script>
	</body>
</html>
