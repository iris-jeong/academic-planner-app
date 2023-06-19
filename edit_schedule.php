<?php
	require "config/config.php";
	$year = $_GET['year'];
	$term = $_GET['term'];
	$schedule_id = $_GET['schedule_id'];
    
    // echo $schedule_id;
    // echo $year;
    // echo $term;

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

    //1. Establish MySQL Connection.
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    //a) Check for connection errors.
    if($mysqli->connect_errno) {
        echo $mysqli->connect_error;
        exit();
    }
    //2. Submit SQL Statement.
    // A. Retrieve the schedule id for the given semester and year.
    $sql_sched_id = "SELECT * FROM schedules
                    WHERE semester_id = $term_id
                    AND year = $year
                    AND schedules.id = $schedule_id;";
    
    $id_results = $mysqli->query($sql_sched_id);
    $sched_id = $id_results->fetch_assoc()['id'];

    if(!$sched_id) {
        $mysqli->error;
        $mysqli->close();
        exit();
    }
    $_SESSION['schedule_id'] = $sched_id;
    
    // B. Retrieve the courses associated with the schedule id. 
    $sql_sched_courses = "SELECT schedule_courses.id, code, number, courses.name AS description, units
                        FROM schedule_courses
                        LEFT JOIN courses ON schedule_courses.course_id = courses.id
                        LEFT JOIN course_codes ON courses.code_id = course_codes.id
                        WHERE schedule_id = $schedule_id;";
    
    $courses_results = $mysqli->query($sql_sched_courses);
    
    if(!$courses_results) {
        $mysqli->error;
        $mysqli->close();
        exit();
    }

    $mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Schedule</title>
    <?php include "config/css.html" ?>
    <link rel="stylesheet" href="css/edit_schedule.css">
</head>
<body>
    <div class="main-container">
        <div class="header">
            <h1><?php echo $term . " " . $year; ?> Courses</h1>
        </div>
        <div class="content">
            <div class="semester-table">
                <form method="POST" action="edit_confirm.php">
                        <table class="table table-striped table-lg">
                            <thead>
                                <tr>
                                    <th scope="col">Course Code</th>
                                    <th scope="col"><div class="margin">Description</div></th>
                                    <th scope="col"><div class="units">Units</div></th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = $courses_results->fetch_assoc()) : ?>
                                    <tr id="<?php echo $row['id']; ?>">
                                        
                                        <input type="hidden" name="<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>">
                                        <td>
                                            <?php echo $row['code'] . " " . $row['number']; ?>
                                        </td>
                                        <td>
                                            <div class="margin">
                                                <?php echo $row['description']; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="units"><?php echo $row['units'] . " units"; ?></div>
                                        </td>
                                        <td> 
                                            <div class="delete-btn">
                                                <img src="icons/remove-red.png" alt="Remove Icon">
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                            
                        </table>
                    
                    <div class="btn-container">
                        <div class="delete-all-btn">Delete schedule</div>
                        
                        <div class="action-buttons">
                            <button class="cancel-btn">
                                <a href="schedule.php">Cancel</a>
                            </button>
                            <button class="next-btn" type="submit">Save edit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- .content -->
    </div>
    <!-- .main-container -->

    <!-- ------------------------- SCRIPTS ----------------------------- -->
    <?php include "config/scripts.html" ?>

    <script>
        //If user clicks a delete button, remove it from the table.
        $(".delete-btn").click(function(e) {
            let row = e.currentTarget.parentElement.parentElement;
            $(row).remove();
        });

        //If user clicks delete schedule button, remove all courses from the table
        $(".delete-all-btn").click(function(e) {
            let row = e.currentTarget.parentElement.parentElement;
            $(row).remove();
            window.location.replace("edit_confirm.php");
        });
    </script>
</body>
</html>
