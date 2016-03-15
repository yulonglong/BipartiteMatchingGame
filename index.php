<?php
session_start();
$user_id = null;
$role = null;
if (isset($_SESSION["user_id"])) {
	$user_id = $_SESSION["user_id"];
	$role = $_SESSION["role"];
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Bipartite Matching Game</title>
		<?php include "inc/section_head.php"; ?>
	</head>
	<body>
		<?php include "inc/section_highscoreModal.php"; ?>
		<?php
			require_once('inc/section_navbar.php');
			getBodyNavbar("index",$user_id);
		?>

		<div class="container">
			<h1>Bipartite Matching Game</h1>
		</div>

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
				<button id="solveButton" type="button" class="btn btn-info btn-lg">Hint</button>
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
									<span>Only logged-in user submission will be saved and shown in leaderboard </span>
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

				<!-- <div id="msg"><p>Select worksheet size and click 'Generate Worksheet'.</p></div> -->
			</div>
			<br/>
			<p>Raccoons designed by <a href="http://www.vecteezy.com/vector-art/86958-cartoon-raccoon-set-vector">Vecteezy</a></p>
			<p>Toasts designed by <a href="https://yulonglong.com">Steven Kester Y</a></p>
		</section>

		
	</body>
	<?php include("inc/section_bottom.php"); ?>
	<script src="js/control.js"></script>
</html>
