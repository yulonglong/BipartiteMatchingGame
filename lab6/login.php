<?php
session_start();
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
		<form method="post" action="">
			User ID
			<input type="text" id="user_id" name="user_id" size="20"/>
			Password
			<input type="password" id="password" name="password" size="30"/>
			<input type="submit" name="login" id="login" class="button" value="login"/>
		</form>
		<br>
		<p class="error_message" id="login_error"></p>
		<br>
		<!-- <a href="reset_password.php">Reset your password</a> -->

		<?php
	}
?>

<body>
	<div class="container">
		<h1>Bipartite Game - Login</h1>
	</div>
	<br>

	<!-- Main -->
	<div class="container center">
				<section>
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
				</section>
	</div>
</body>
</html>