<?php
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
	//Fill out nav bar user info with name, and major
	$fname = $_SESSION['first_name'];
	$lname = $_SESSION['last_name'];
	$majorID = $_SESSION['major_id'];

	//Make SQL query to get the major name using the ID.
	$sql_major = "SELECT name
				FROM majors_minors
				WHERE id = $majorID;";
	$major = $mysqli->query($sql_major);
	if(!$major) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}
	$major = $major->fetch_assoc()['name'];
?>
<div class="nav-container">
	<div class="user-info">
		<img
			src="images/tommyprofile.jpeg"
			alt="Profile Picture"
			class="profile-pic rounded-circle"
		/>
		<div class="ml-3">
			<p class="name mb-0"><?php echo $fname . " " . $lname ?></p>
			<small><?php echo $major ?></small>
		</div>
	</div>
	<div><hr /></div>
	<div class="nav-links-container">
		<div class="nav-item">
			<a href="schedule.php">
				<img
					class="icons"
					src="icons/ScheduleIcon.png"
					alt="My Schedule Icon"
				/>
				My Schedule
			</a>
		</div>
		<div class="nav-item">
			<a href="semester_term.php">
				<img
					class="icons"
					src="icons/planner.png"
					alt="Semester Planner Icon"
				/>
				Semester Planner
			</a>
		</div>
		<div class="nav-item">
			<a href="project_summary.php">
				<img
					class="icons"
					src="icons/summary.png"
					alt="Project Summary Icon"
				/>
				Project Summary
			</a>
		</div>

		<div class="nav-item">
			<a href="logout.php">
				<img
					class="icons"
					src="icons/logout.png"
					alt="Logout Icon"
				/>
				Log Out
			</a>
		</div>
	</div>
	<!-- .nav-elements-->
</div>
<!-- .nav-container -->