<?php
    require "config/config.php";
    // echo "<pre>";
    // echo var_dump($_POST);
    // echo "</pre>";

    $user_id = $_SESSION['user_id'];
    $year = $_POST['year'];
    $term = $_POST['term'];
    $term_id;
    if($term == "Spring") {
        $term_id = 1;
    }
    else if($term == "Summer") {
        $term_id = 2;
    }
    else {
        $term_id = 3;
    }

    $course_ids = array();
    
    foreach($_POST as $key=>$value)
    {
        array_push($course_ids, "$key");
    }
    array_splice($course_ids, 0, 2);

    // echo "<pre>";
    // var_dump($course_ids);
    // echo "</pre>";

    // foreach($course_ids as $key=>$value) {
    //     echo $value;
    // }
    
    //1. Establish MySQL Connection.
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	// a) Check for connection errors.
	if($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}
    //2. Submit SQL Statement.
    // A) Insert a row into schedules table with semester_id, year, and user_id
    $sql_schedule = "INSERT INTO schedules (semester_id, year, user_id)
                        VALUES ($term_id, $year, $user_id);";
    $schedule = $mysqli->query($sql_schedule);
    if(!$schedule){
        $mysqli->error;
        $mysqli->close();
        exit();
    }

    // B) Insert a row into schedule_courses table with schedule_id, and course_id for each course.
    $sql_schedule_id = "SELECT Max(id) AS id FROM schedules;";
    $results = $mysqli->query($sql_schedule_id);
    $schedule_id = $results->fetch_assoc();
    if(!$schedule_id) {
        $mysqli->error;
        $mysqli->close();
        exit();
    }
    $id = $schedule_id['id'];

    foreach($course_ids as $key=>$value) {
        $sql_schedule_course = "INSERT INTO schedule_courses (schedule_id, course_id)
                                VALUES ($id, $value);";
        $schedule_course = $mysqli->query($sql_schedule_course);
        if(!$schedule_course) {
            $mysqli->error;
            $mysqli->close();
            exit();
        }
    }

    //Close DB Connection.
    $mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation</title>
    <?php include "config/css.html" ?>
    <link rel="stylesheet" href="css/plan_confirmation.css" />
</head>
<body>
    <div class="main-container">
        <div class="content">
            <div class="content-child">
                <h1>Your schedule has been created!</h1>
                <div class="body">
                    <a href="schedule.php">Go to your schedule</a>
                </div>
            </div>    
        </div>
    </div>
    <?php include "config/scripts.html" ?>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
    <script>
        confetti({
            particleCount: 300,
            startVelocity: 30,
            spread: 360,
            origin: {
            //     x: Math.random(),
            //     // since they fall down, start a bit higher than random
                y: 0.2
            }
        });
        window.addEventListener("click", () => {
            
            confetti({
                particleCount: 300,
                startVelocity: 30,
                spread: 360,
                origin: {
                    x: Math.random(),
                    // since they fall down, start a bit higher than random
                    y: Math.random() - 0.2
                }
            });
        });
    </script>
</body>
</html>