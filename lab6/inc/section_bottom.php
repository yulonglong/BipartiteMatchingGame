<script src="http://code.jquery.com/jquery-2.2.0.min.js"></script>
<script src="js/helper.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha256-KXn5puMvxCw+dAYznun+drMdG1IFl3agK0p/pqT9KAo= sha512-2e8qq0ETcfWRI4HJBzQiA3UoyFk6tbNyG+qSaIBZLyW9Xf3sWZHN/lxe9fTh1U45DpPf07yj94KsUHHWe4Yk1A==" crossorigin="anonymous"></script>
<div class="container text-center">
	<p><?php 
	if (isset($database) && $database != null)
		echo $database->getElapsedTime(); 
	?></p>
</div>
