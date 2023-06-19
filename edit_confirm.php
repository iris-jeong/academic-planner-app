<?php
    require "config/config.php";
    
    // echo "<pre>";
    // echo var_dump($_POST);
    // echo "</pre>";

    $sched_id = $_SESSION['schedule_id'];
    $sched_course_ids = array();
    foreach($_POST as $key=>$value)
    {
        array_push($sched_course_ids, "$key");
    }

    //1. Establish MySQL Connection.
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    //a) Check for connection errors.
    if($mysqli->connect_errno) {
        echo $mysqli->connect_error;
        exit();
    }
    //2. Submit SQL Statement.
    //If user deleted the schedule.
    if(count($_POST) == 0) {
        //Delete all the courses from the schedule_courses table with the given schedule_id.
        $sql_delete_courses = "DELETE FROM schedule_courses
                                WHERE schedule_id = $sched_id;";
        $delete_courses = $mysqli->query($sql_delete_courses);
        if(!$delete_courses) {
            $mysqli->error;
            $mysqli->close();
            exit();
        }
        //Delete the schedule from the schedules table with the given schedule_id.
        $sql_delete_schedule = "DELETE FROM schedules
                                WHERE id = $sched_id;";
        $delete_schedule = $mysqli->query($sql_delete_schedule);
        if(!$delete_schedule) {
            $mysqli->error;
            $mysqli->close();
            exit();
        }
    }
    else {
        //Update courses from the schedule_courses table with the given schedule_id.
        $sql_all_courses = "SELECT * FROM schedule_courses
                            WHERE schedule_id = $sched_id;";
        $all_courses = $mysqli->query($sql_all_courses);
        $courses = [];
        $index = 0;
        while($row = $all_courses->fetch_assoc()) {
            if($row['id'] != $sched_course_ids[$index]) {
                $sched_course_id = $row['id'];
                $sql_delete_sched_course = "DELETE FROM schedule_courses
                                            WHERE id = $sched_course_id;";
                $delete_sched_course = $mysqli->query($sql_delete_sched_course);
                if(!$delete_sched_course) {
                    $mysqli->error;
                    $mysqli->close();
                    exit();
                }
            }
            $index = $index + 1;
        }
    }

    $mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Confirmation</title>
    <?php include "config/css.html" ?>
    <link rel="stylesheet" href="css/edit_confirm.css">
</head>
<body>
    <div class="container">
        <!-- <div class="content"> -->
            <h1>
                Your changes have been saved!
            </h1>
            <div class="back-button">
                <a href="schedule.php">Go to your schedule</a>
            </div>
    <!-- </div> -->
    </div>
</body>
</html>