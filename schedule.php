<?php
	require "config/config.php";
	// echo "<pre>";
	// echo var_dump($_SESSION);
	// echo "</pre>";

	//1. Establish MySQL Connection.
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	// a) Check for connection errors.
	if($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}
	//2. Submit SQL Statement.
	$hasSchedules;
	if(!isset($_SESSION['user_id'])) {
		$hasSchedules = false;
	}
	else {
		// a) Retrieve information on user's schedules
		$userID = $_SESSION['user_id'];

		$sql_user_schedules = "SELECT schedules.id, semester_id, year, user_id, name FROM schedules 
							LEFT JOIN users ON schedules.user_id = users.id
							LEFT JOIN semesters ON schedules.semester_id = semesters.id
							WHERE user_id = $userID;";
		
		//i) Get the schedule IDs
		$schedules = $mysqli->query($sql_user_schedules);
		if (!$schedules) {
			// echo $mysqli->error;
			$mysqli->close();
			exit();
		}
		//b) If the users doesn't have any planned schedules, display a message saying no schedules to show
		if($schedules->num_rows == 0) {
			$hasSchedules = false;
		}
		else {
			//c) If the user has schedules that they've planned display them
			//i) Get the courses for each of the schedules the user has planned
			$hasSchedules= true;
		}
	}

	/** 3) Close the DB Connection **/
	$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Schedule</title>
        <?php include "config/css.html" ?>
		<link rel="stylesheet" href="css/schedule.css" />
	</head>
	<body>
		<div class="main-container">
            <?php include "config/nav.php" ?>
			<div class="content">
				<div class="content-child">
					<div class="header">
						<h1>Schedules</h1>
					</div>
					<!-- .header -->
					<div class="body">
						<!-- For each semester, output the schedule here-->
						<?php if(!$hasSchedules) : ?>

							<!-- If there are NO schedules to display -->
							<div class="no-schedules">No schedules to display</div>

						<?php else : ?>

							<!-- If there ARE schedules to display -->
							<?php while($row = $schedules->fetch_assoc()) : ?>
								<div class="semester-container mr-auto">
									<?php 
									// echo "<pre>";
									// echo var_dump($row); 
									// echo "</pre>";
									?>
									<div class="sem-title semester"><?php echo $row['name']; ?></div>
									<div class="sem-title year"><?php echo $row['year']; ?></div>
									<form action="edit_schedule.php" method="GET">
										<input type="hidden" name="term" value="<?php echo $row['name']; ?>">
										<input type="hidden" name="year" value="<?php echo $row['year']; ?>">
										<input type="hidden" name="schedule_id" value="<?php echo $row['id']; ?>">
										<button class="btn">edit</button>
									</form>
									<!-- <a class="edit-btn" href="edit_schedule.php">edit</a> -->
								</div>
								<!-- .semester-container -->	

								<?php
									$schedule_id = $row['id'];

									// echo $schedule_id;

									$sql_courses = 	"SELECT number, courses.name AS description, units, code FROM schedule_courses
													LEFT JOIN courses ON schedule_courses.course_id = courses.id
													LEFT JOIN course_codes ON courses.code_id = course_codes.id
													WHERE schedule_id = $schedule_id;";
									
									// echo $sql_courses;

									$courses = $mysqli->query($sql_courses);
									if (!$courses) {
										echo $mysqli->error;
										$mysqli->close();
										exit();
									}
								?>

								<div class="cards-container">
									<?php while($course_row = $courses->fetch_assoc()) : ?>
										<div class="card">
											<div class="card-body">
												<h5 class="card-title phil"><?php echo $course_row['code'] . " " . $course_row['number']; ?></h5>
												<p class="card-text">
													<?php echo $course_row['description']; ?>
												</p>
												<span class="badge rounded-pill gray mb-3">
													<?php echo $course_row['units'] . " units"; ?>
												</span>
											</div>
										</div>
									<?php endwhile; ?>			
								</div><!-- .cards-container -->
							<?php endwhile; ?>
						<?php endif; ?>
						
					</div>
					<!-- .body -->
				</div>
				<!-- .content -->
			</div>
		</div>
		<!-- .main-container -->
		<!-- ------------------------- SCRIPTS ----------------------------- -->
		<?php include "config/scripts.html" ?>
		
	</body>
</html>
