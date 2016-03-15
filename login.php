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
	<title>Bipartite Matching Game - Login</title>
	<?php include "inc/section_head.php"; ?>
</head>

<?php
	function showLoginForm($feedback_message = "") {
		?>
		<div class="container text-center">
			<form class="form-horizontal" method="post" action="">
				<fieldset>
					<label for="user_id" class="sr-only">User ID</label>
					<input type="text" id="user_id" name="user_id" class="form-control" placeholder="User ID" required autofocus>
					<label for="password" class="sr-only">Password</label>
					<input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
					<br>
					<button class="btn btn-primary btn-block" type="submit" name="login" id="login" value="login">Log in</button>
				</fieldset>
			</form>
			<br>
			<p><a href="register.php" class="text-center new-account">Create an account </a></p>
			<br>
			<p class="error_message" id="login_error"><b style="color : red;"><?php echo $feedback_message; ?></b></p>
			<br>
		</div> <!-- /container -->
		<?php
	}
?>

<body>
	<?php include "inc/section_highscoreModal.php"; ?>
	<?php
		require_once('inc/section_navbar.php');
		getBodyNavbar("login",$user_id);
	?>

	<div class="container text-center">
		<h1>Login Page</h1>
	</div>
	<br>

	<!-- Main -->
	<?php
		if (isset($_POST["user_id"]) && isset($_POST["password"])) {
			require_once("Database.php");
			$database = new Database();
			$user_id = $_POST["user_id"];
			$password = $_POST["password"];
			$feedback = "";
			$role = $database->login($user_id,$password,$feedback);
			if ($role != -1) {
				$_SESSION["user_id"] = $user_id;
				$_SESSION["role"] = $role;
				if ($role == 0) header('Location: admin.php');
				else header('Location: index.php');
				return;
			}
			else {
				showLoginForm($feedback);
			}
		}
		else {
			session_unset(); 
			session_destroy(); 
			showLoginForm();
		}
	?>
</body>
<?php include("inc/section_bottom.php"); ?>
</html>