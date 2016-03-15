<?php
session_start();
$user_id = null;
$role = null;
if (isset($_SESSION["user_id"])) {
	$user_id = $_SESSION["user_id"];
	$role = $_SESSION["role"];
}
require_once("Database.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Bipartite Matching Game - Register</title>
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
					<li><a href="admin.php">Admin</a></li>
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
		<h1>Registration</h1>
	</div>
	<br>

	<?php 

	$feedback = "";
	$showForm = true;
	$username = "";
	$email = "";
	$password = "";
	$password_confirm = "";

	if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["password_confirm"])) {
		$username = $_POST["username"];
		$email = $_POST["email"];
		$password = $_POST["password"];
		$password_confirm = $_POST["password_confirm"];

		$database = new Database();
		$isSuccessful = $database->registerUser($username,$email,$password,$password_confirm,$feedback);
		if ($isSuccessful) {
			$showForm = false;
			$feedback = "<b style='color : green'>".$feedback."</b>";
		}
		else {
			$showForm = true;
			$feedback = "<b style='color : red'>".$feedback."</b>";
		}
	}
	?>

	<div class="container text-center">
		<p><?php echo $feedback; ?></p>
	</div>

	<?php if ($showForm) { ?>
	<div class="container text-center">
		<form class="form-horizontal" action='' method="POST">
			<fieldset>
				<div class="control-group">
					<!-- Username -->
					<label class="control-label"  for="username">Username</label>
					<div class="controls">
						<input type="text" id="username" name="username" placeholder="" class="form-control" value=<?php echo '"'.$username.'"';?>>
						<p class="help-block">Username can contain any letters or numbers, without spaces</p>
					</div>
				</div>
		 
				<div class="control-group">
					<!-- E-mail -->
					<label class="control-label" for="email">E-mail</label>
					<div class="controls">
						<input type="text" id="email" name="email" placeholder="" class="form-control" value=<?php echo '"'.$email.'"';?>>
						<p class="help-block">Please provide your e-mail to reset password, no spam.</p>
					</div>
				</div>
		 
				<div class="control-group">
					<!-- Password-->
					<label class="control-label" for="password">Password</label>
					<div class="controls">
						<input type="password" id="password" name="password" placeholder="" class="form-control">
						<p class="help-block">Password should be at least 4 characters</p>
					</div>
				</div>
		 
				<div class="control-group">
					<!-- Password -->
					<label class="control-label"  for="password_confirm">Confirm Password</label>
					<div class="controls">
						<input type="password" id="password_confirm" name="password_confirm" placeholder="" class="form-control">
						
					</div>
				</div>
		 		<br>
				<div class="control-group">
					<!-- Button -->
					<div class="controls">
						<button class="btn btn-info">Register</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>

	<?php } else { ?>

	<div class="container text-center">
		<p><a href="login.php">Go to login page</a></p>
	</div>

	<?php } ?>

</body>
<?php include("inc/section_bottom.php"); ?>
</html>