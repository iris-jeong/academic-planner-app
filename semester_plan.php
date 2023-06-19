<?php 
	require "config/config.php";
	$term = $_POST['term'];
	$year = $_POST['year'];
	$major = $_SESSION['major_id'];

	//1. Establish MySQL Connection.
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	//a) Check for connection errors.
	if($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}
	//2. Submit SQL Statement.
	//a) Write the SQL statement; Retrieve requirements for the user's major.
	$sql_major_requirements = "SELECT * FROM requirements
							WHERE major_minor_id = $major;";
	$major_requirements = $mysqli->query($sql_major_requirements);
	if(!$major_requirements) {
		$mysqli->error;
		$mysqli->close();
		exit();
	}

	//3. Close the DB Connection.
	$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Semester Planner</title>
        <?php include "config/css.html" ?>
		<link rel="stylesheet" href="css/semester_plan.css" />
		</style>
	</head>
	<body>
		<div class="main-container">

        <?php include "config/nav.php" ?>

			<div class="content">
				<div class="content-child">
					<div class="header">
						<h1>Choose your classes for the semester.</h1>
					</div>
					<!-- .header -->
					<div class="body">
						<form action="plan_confirmation.php" method="POST" class="course-form">
						<input type="hidden" name="term" value=<?php echo $term;?> >
						<input type="hidden" name="year" value=<?php echo $year;?> >
							<div class="accordion-container">

								<?php while($row = $major_requirements->fetch_assoc()) : ?>

									<div class="accordion-title">
										<?php echo $row['name'] . " Requirements (" . $row['units'] . " units total)"; ?>
										<img class="down-arrow-icon" src="icons/down-arrow.png" alt="Down Arrow">
									</div>
									<!-- .accordion -->

									<div class="accordion-panel">

										<?php 
											$requirement_id = $row['id'];
											$sql_courses = "SELECT courses.id as courseid, number, courses.name as course, units, code
															FROM course_requirements
															LEFT JOIN courses ON course_requirements.course_id = courses.id
															LEFT JOIN course_codes ON courses.code_id = course_codes.id
															WHERE requirement_id = $requirement_id;";
											$courses = $mysqli->query($sql_courses);
											if(!$courses) {
												$mysqli->error;
												$mysqli->close();
												exit();
											}
										?>
										<?php while($course_row = $courses->fetch_assoc()) : ?>
											<div class="form-group d-flex align-items-center">
												<div class="input-container">
													<input type="checkbox" 
															name="<?php echo $course_row['courseid']; ?>" 
															id="<?php echo $course_row['code'] . $course_row['number']; ?>" 
															value="<?php echo $course_row['code'] . $course_row['number']; ?>"
													/>
												</div>
												<div class="label-container">
													<label class="label" for="<?php echo $course_row['code'] . $course_row['number'] ?>">
														<?php echo $course_row['code'] . " " 
														. $course_row['number'] . " - " 
														. $course_row['course'] . " (" 
														. $course_row['units'] . " Units)" ; ?>
													</label>
												</div>
											</div>
											<!-- .form-group -->
										<?php endwhile; ?> 

									</div>
									<!-- panel -->

								<?php endwhile; ?>
							</div>
							<!-- .accordion-container -->
							<div class="semester-table">
								<table class="table">
									<thead>
										<tr>
											<th scope="col">Courses Added</th>
										</tr>
									</thead>
									<tbody>
										<!-- <tr class="no-classes-tr">
											<td>No classes added!</td>
										</tr> -->
									</tbody>
									
								</table>
							</div>
							<div class="btn-container">
								<button class="next-btn" type="submit">Create semester plan</button>
							</div>
						</form>
					</div>
					<!-- .body -->				
				</div>
				<!-- .content-child -->		
			</div>
			<!-- .content -->
		</div>
		<!-- .main-container -->

		<!-- ------------------------- SCRIPTS ----------------------------- -->
        <?php include "config/scripts.html" ?>
		<script>
			//Accordion
			var acc = document.getElementsByClassName("accordion-title");
			var i;

			for (i = 0; i < acc.length; i++) {
			acc[i].addEventListener("click", function() {
				this.classList.toggle("active");
				var panel = this.nextElementSibling;
				if (panel.style.maxHeight) {
				panel.style.maxHeight = null;
				} else {
				panel.style.maxHeight = panel.scrollHeight + "px";
				} 
			});
			}

			//Checkboxes
			$("input[type='checkbox']").change(function(){	
				$("input[value='"+$(this).val()+"'][type='checkbox']").prop("checked", $(this).prop("checked"));

				let course = $(this).parent().next().children()[0].innerText;
				let courseCode = $(this).val();
				let courseElement =  $(this).parent().next().children()[0];

				if($(this).is(":checked")) {
					createRow(course, courseCode);
				}
				else {
					deleteRow(courseCode);
				}
			});

			//Courses Added Table
			//If there are classes in the table, remove the no classes added message.
			$(document).ready(function() {
				$('#select').click(function() {
					var checkboxes = $('input:checkbox:checked').length;
					alert(checkboxes);
				})
			});
			console.log($("tbody").children()[0]);
			console.log($("tbody")[0].childElementCount);
			if($("tbody")[0].childElementCount > 1) {
				console.log($("tbody")[0].childElementCount);
				$("tbody")[0].children()[0].remove();			
				console.log($("tbody")[0].children[0]);	
			}
			else if($("tbody")[0].childElementCount == 0) {
				var tr = document.createElement("tr");
				var td = document.createElement("td");
				tr.addClass("no-classes-tr");
				td.innerHTML = "No classes added!";
				document.querySelector('tbody').append(tr);
			}

			function createRow(info_, id_) {
				var tr = document.createElement("tr");
				var td_course = document.createElement("td");

				$(td_course).attr("id", id_);
				td_course.innerHTML = info_;
				$(tr).append(td_course);
				document.querySelector('tbody').append(tr);
			}

			function deleteRow(id_) {
				//Search for the table data element with the id that matches
				let courseID = "#" + id_;
				$("tbody").find(courseID)[0].parentElement.remove();
			}

		</script>

	</body>
</html>


