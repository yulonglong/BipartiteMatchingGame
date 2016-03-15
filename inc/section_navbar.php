<?php
function getBodyNavbar($currentPage, $user_id) {
	echo
	'<nav class="navbar navbar-inverse navbar-static-top">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="http://yulonglong.com">Yulonglong.com</a>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">';
					if ($currentPage == "index") {
						echo '<li class="active"><a href="index.php">Main</a></li>';
					}
					else {
						echo '<li><a href="index.php">Main</a></li>';
					}

					if ($currentPage == "admin") {
						echo '<li class="active"><a href="admin.php">Admin</a></li>';
					}
					else {
						echo '<li><a href="admin.php">Admin</a></li>';
					}
					echo '</ul>
					<form class="navbar-form navbar-left" role="search">
						<div class="form-group">
							<input id="highscoreGraphId" type="number" class="form-control" placeholder="ID"  min="1" max="9">
							<button type="button" class="btn btn-success" data-toggle="modal" data-target="#highscoreModal" onclick="getHighscoreByIdAJAX(-1);">High Score</button>
						</div>
					</form>

					<ul class="nav navbar-nav navbar-right">';
						if ($user_id != null) {
							echo "<li><a>Welcome, <span id=\'username\'>".$user_id."</span></a></li>";
						}
						
						if ($currentPage == "login") {
							echo '<li class="active"><a href="logout.php">';
						}
						else {
							echo '<li><a href="logout.php">';
						}

						if ($user_id != null) echo "Logout";
						else echo "Login";
							
						echo '
						</a></li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div>
		</nav>';
}
?>