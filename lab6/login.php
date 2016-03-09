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
	<title>Bipartite Game - Login</title>
	<?php include "inc/section_head.php"; ?>
</head>

<?php
	function showLoginForm() {
		?>
		<div class="container">
			<div class="col-sm-6 col-md-4 col-md-offset-4">
				<form method="post" action="">
					<label for="user_id" class="sr-only">User ID</label>
					<input type="text" id="user_id" name="user_id" class="form-control" placeholder="User ID" required autofocus>
					<label for="password" class="sr-only">Password</label>
					<input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
					<br>
					<button class="btn btn-lg btn-primary btn-block" type="submit" name="login" id="login" value="login">Log in</button>
				</form>
				<br>
				<p><a href="#" class="text-center new-account">Create an account </a></p>
				<br>
				<p class="error_message" id="login_error"></p>
				<br>
			</div> <!-- /container -->
		</div>
		<?php
	}
?>

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
					<li><a href="index.php">Main<span class="sr-only">(current)</span></a></li>
					<li><a href="admin.php">Admin Page</a></li>
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
					<li class="active"><a href="logout.php">
						<?php
							if ($user_id != null) echo "Logout";
							else echo "Login";
						?>
					<span class="sr-only">(current)</span></a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div>
	</nav>

	<div class="container">
		<h1>Bipartite Game - Login</h1>
	</div>
	<br>

	<!-- Main -->
	<div class="container center">
			<?php
				$database = new Database();
				
				if (isset($_POST["user_id"]) && isset($_POST["password"])) {
					$user_id = $_POST["user_id"];
					$password = $_POST["password"];
					$role = $database->login($user_id,$password);
					if ($role != -1) {
						$_SESSION["user_id"] = $user_id;
						$_SESSION["role"] = $role;
						header('Location: index.php');
					}
					else {
						showLoginForm();
						?>
						<script>
							document.getElementById("login_error").innerHTML = "Invalid User ID or Password";
						</script>
						<?php
					}
				}
				else {
					// remove all session variables
					session_unset(); 
					// destroy the session 
					session_destroy(); 
					showLoginForm();
				}
		?>
	</div>
</body>
</html>