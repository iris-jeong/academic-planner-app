<?php 
	require "config/config.php";
	// echo $_POST['term'];
	$term = $_POST['term'];
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
						<div class="year-title">
							<h1 class="">Choose a year</h1>
						</div>
					</div>
					<!-- .header-->
					<div class="body">
						<form method="POST" action="semester_plan.php" id="radio-cards-container">
							<input type="hidden" name="term" value=<?php echo $term;?> >
							<div class="col-md-4 col-lg-4 col-sm-4">
											
								<label>
								<input type="radio" name="year" class="card-input-element" value="2021"/>

									<div class="panel panel-default card-input">
										<div class="panel-body">
											2021
										</div>
									</div>

								</label>
								
							</div>
							<div class="col-md-4 col-lg-4 col-sm-4">
										
							<label>
							<input type="radio" name="year" class="card-input-element" value="2022" checked/>

								<div class="panel panel-default card-input">
									<div class="panel-body">
										2022
									</div>
								</div>

							</label>
							
						</div>
						<div class="col-md-4 col-lg-4 col-sm-4">
										
							<label>
							<input type="radio" name="year" class="card-input-element" value="2023"/>

								<div class="panel panel-default card-input">
									<div class="panel-body">
										2023
									</div>
								</div>

							</label>
							
						</div>
						<div class="btn-container">
							<button class="next-btn" type="submit">Next</button>
						</div>
						</form>
						<!-- .radio-cards-container -->
					</div>
					<!-- .body -->
					<!-- <div class="footer">
						<div class="bottom-nav-container">
							<div>
								<a class="buttons" href="semester_term.php"
									>Back</a
								>
							</div>

							<div>
								<a class="buttons" href="semester_plan.php"
									>Next</a
								>
							</div>
						</div> -->
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
			const selectRadioCard = (cardNo) => {
				/**
				 * Loop through all radio cards, and remove the class "selected" from those elements.
				 */
				const allRadioCards = document.querySelectorAll(".radio-card");
				allRadioCards.forEach((element, index) => {
					element.classList.remove(["selected"]);
				});
				/**
				 * Add the class "selected" to the card which user has clicked on.
				 */
				const selectedCard = document.querySelector(
					".radio-card-" + cardNo
				);
				selectedCard.classList.add(["selected"]);
			};
		</script>
	</body>
</html>
