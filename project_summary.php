
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<title>ITP 304 Project Summary</title>

        <?php include "config/css.html" ?>

		<style>
			body {
				height: 100vh;
			}
			.container {
				width: 800px;
				padding: 30px 0px 100px 0px;
			}
			a {
				width: 200px;
			}
		</style>
	</head>
	<body class="mt-5">
		<div class="container">
			<h1>Project Summary</h1>
			<br />

			<p>
				This project is a semester planning system for students. Its
				purpose is to help plan which courses to take in order to stay
				on track with fulfilling their major and minor requirements.
			</p>
			<h2>Purpose</h2>
			<p>
				Currently, USC students can utilize the STARS report to know
				what classes they've already taken and to determine which
				classes they still need to take. However, the report can be hard
				to read and difficult to understand to use.
			</p>
			<p>
				This project aims to simplify the process and make the
				experience of planning your academic career more enjoyable.
			</p>
			<br />
			<h2>Database</h2>
			<p>The data for my page comes from the USC course catalogue.</p>
			<img
				src="images/itp304diagram.png"
				alt="Database Diagram"
			/>
			<br />
			<h2>Extras</h2>
			<p>To help with styling, I used a few bootstrap elements.</p>

			<br />
			<div class="d-flex justify-content-center">
				<a class="btn buttons" href="schedule.php">Go to Project</a>
			</div>
		</div>
	</body>
</html>
