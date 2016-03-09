<?php
session_start();
if (!isset($_SESSION["user_id"])) {
	header('Location: login.php');
}
else {
	$user_id = $_SESSION["user_id"];
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Lab 6 - Matching Game</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous">

		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto">
		
	</head>
	<body>
		<h1>Matching Game</h1>

		<section id="main">
			<h3 id="gameMode"></h3>
			<h3>Click to feed the raccoons!</h3>
			<p><span class="mainMsg"></span></p>
			<p><span class="msg"></span></p>
			<div class= "container center">
				<table id="theTable" class="center">
					<tr>
						<td class="leftTd" width="20%" ><div id="ulLeft"  class="center"></div></td>
						<td class="middleTd" width="60%" id="tdMiddle"><canvas id="cvs"></canvas></td>
						<td class="rightTd" width="20%"><div id="ulRight"  class="center"></div></td>
					</tr>
				</table>
			</div>

			<p><span class="mainMsg"></span></p>
			<p><span class="msg"></span></p>

			<div class="container center">
				<!-- Trigger the modal with a button -->
				<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Reset</button>
				<button id="solveButton" type="button" class="btn btn-info btn-lg">Solve</button>
				<button id="submitButton" type="button" class="btn btn-info btn-lg">Submit</button>
			</div>
			<br>
			<div class="container center">
				<button id="highscoreButton" type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#highscoreModal">High Score</button>
			</div>
			<div class="container center">
				<!-- Modal -->
				<div class="modal fade" id="myModal" role="dialog">
					<div class="modal-dialog modal-sm">

					<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Number of images</h4>
							</div>
							<div class="modal-body">
								<p>
									<span>Practice : Left (0 to disable): </span><input type="number" class="form-control" min="2" max="10" value="0" id="numberOfImagesLeft">
								</p>
								<p>
									<span>Practice : Right (0 to disable): </span><input type="number" class="form-control" min="2" max="10" value="0" id="numberOfImagesRight">
								</p>
								<br>
								<p>
									<span>Name (shown in leaderboard) </span><input type="text" maxlength="9" class="form-control" value="Anonymous" id="username">
								</p>
								<p>
									<span>Competitive : Graph ID (0 to disable): </span><input type="number" class="form-control" min="1" max="9" value="1" id="graphId">
								</p>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-primary" id="btn" onclick="generateWorksheet();" data-dismiss="modal">Generate Worksheet</button>
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							</div>
						</div>
					</div>
				</div>

				<!-- Modal -->
				<div class="modal fade" id="highscoreModal" role="dialog">
					<div class="modal-dialog">

					<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Leaderboard</h4>
							</div>
							<div class="modal-body">
								<h5 class="text-center" id="tblDescription"></h5>
								<table class="table table-striped" id="tblGrid">
									<thead id="tblHead">
										<tr>
											<th class="text-center hidden-xs">Rank</th>
											<th class="text-center">Name</th>
											<th class="text-center">Matches</th>
											<th class="text-center">Score</th>
											<th class="text-center">Duration (secs)</th>
											<th class="text-center hidden-xs">Timestamp (SGT)</th>
										</tr>
									</thead>
									<tbody id="tblBody">
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				<!-- <div id="msg"><p>Select worksheet size and click 'Generate Worksheet'.</p></div> -->
			</div>
			<br/>
			<p>Raccoons designed by <a href="http://www.vecteezy.com/vector-art/86958-cartoon-raccoon-set-vector">Vecteezy</a></p>
			<p>Toasts designed by <a href="https://yulonglong.com">Steven Kester Y</a></p>
		</section>

		
	</body>

	<script src="http://code.jquery.com/jquery-2.2.0.min.js"></script>
	<script src="js/helper.js"></script>
	<script src="js/control.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha256-KXn5puMvxCw+dAYznun+drMdG1IFl3agK0p/pqT9KAo= sha512-2e8qq0ETcfWRI4HJBzQiA3UoyFk6tbNyG+qSaIBZLyW9Xf3sWZHN/lxe9fTh1U45DpPf07yj94KsUHHWe4Yk1A==" crossorigin="anonymous"></script>
</html>
