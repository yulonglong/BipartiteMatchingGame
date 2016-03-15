<?php
session_start();
$user_id = null;
$role = null;
if (!isset($_SESSION["user_id"])) {
	header('Location: login.php');
	return;
}
else {
	$user_id = $_SESSION["user_id"];
	$role = $_SESSION["role"];
}

$database = null;
if ($role == 0) require_once("Database.php");

if (isset($_GET["reset"]) && ($role == 0)) {
	if ($_GET["reset"] == true) {
		$database = new Database();
		$database->resetHighScore($_SESSION["user_id"]);
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Bipartite Matching Game - Administrator</title>
	<?php include "inc/section_head.php"; ?>
</head>

<body>
	<?php include "inc/section_highscoreModal.php"; ?>
	<nav class="navbar navbar-inverse navbar-static-top">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php">Bipartite Matching</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="index.php">Main</a></li>
					<li class="active"><a href="admin.php">Admin<span class="sr-only">(current)</span></a></li>
				</ul>
				<form class="navbar-form navbar-left" role="search">
					<div class="form-group">
						<input id="highscoreGraphId" type="number" class="form-control" placeholder="ID"  min="1" max="9">
						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#highscoreModal" onclick="getHighscoreByIdAJAX(-1);">High Score</button>
					</div>
				</form>

				<ul class="nav navbar-nav navbar-right">
					<?php
						if ($user_id != null) {
							echo "<li><a>Welcome, <span id='username'>".$user_id."</span></a></li>";
						}
					?>
					<li><a href="logout.php">
						<?php
							if ($user_id != null) echo "Logout";
							else echo "Login";
						?>
					</a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div>
	</nav>

	<div class="container">
		<h1>Administrator</h1>
	</div>
	<br>

	<?php
	if ($role == 0) { 
		if ($database == null) $database = new Database();
	?>

	<!-- Main -->
	<div class="container center">
		<br>
		<h2>Registered Users</h2>
		<table class="table table-striped table-admin" id="tblGrid">
			<thead>
				<tr>
					<th class="text-center">User</th>
					<th class="text-center">Role</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$users = $database->getAllUsers();
					for($i=0;$i<count($users);$i++) {
						echo '<tr><td class="text-center">'.$users[$i]["user_id"].'</td><td class="text-center">'.$users[$i]["role"].'</td>';
					}
				?>
			</tbody>
		</table>
		<br>
		<h2>Leaderboard</h2>
		<table class="table table-striped table-admin" id="tblGrid">
			<thead>
				<tr>
					<th class="text-center">Graph ID</th>
					<th class="text-center">Name</th>
					<th class="text-center">Matches</th>
					<th class="text-center">Score</th>
					<th class="text-center">Duration (secs)</th>
					<th class="text-center">Timestamp (SGT)</th>
				</tr>
			</thead>
			<tbody>
				<?php
					for($i=1;$i<=9;$i++) {
						$score = $database->getBestScore($i);
						if ($score != null) {
							echo '<tr>'.
							'<td class="text-center">'.$i.'</td>'.
							'<td class="text-center">'.$score["name"].'</td>'.
							'<td class="text-center">'.$score["num_match"].'</td>'.
							'<td class="text-center">'.$score["match_score"].'</td>'.
							'<td class="text-center">'.$score["duration"].'</td>'.
							'<td class="text-center">'.$score["date"].'</td>';
						}
						else {
							echo '<tr>'.
							'<td class="text-center">'.$i.'</td>'.
							'<td class="text-center">-</td>'.
							'<td class="text-center">-</td>'.
							'<td class="text-center">-</td>'.
							'<td class="text-center">-</td>'.
							'<td class="text-center">-</td>';
						}
					}
				?>
			</tbody>
		</table>
	</div>
	<div class="container center">
		<!-- Trigger the modal with a button -->
		<button type="button" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#resetModal">Clear Highscore</button>
	</div>
	<div class="container center">
		<!-- Modal -->
		<div class="modal fade" id="resetModal" role="dialog">
			<div class="modal-dialog modal-sm">

			<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Clear Highscore</h4>
					</div>
					<div class="modal-body">
						<h5 class="text-center">Are you sure?</h5>
					</div>
					<div class="modal-footer">
						<a href="admin.php?reset=true" class="btn btn-success">Yes</a>
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php } else { ?>
	<div class="container center">
		<h3>Unauthorized</h3>
	</div>
	<?php } ?>

</body>
<?php include("inc/section_bottom.php"); ?>
</html>
