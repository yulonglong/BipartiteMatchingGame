<?php
require_once("Hungarian.php");

if (!isset($_GET["cmd"])) {
	echo "Please specify command!";
	return;
}

$cmd = $_GET["cmd"];

if ($cmd == "generate") {
	generateGraph();
}
else if ($cmd = "solve") {
	solveGraph();
}
else {
	echo "Sorry, command is not supported!";
	return;
}

function generateGraph() {
    if (!isset($_GET["N"]) || !isset($_GET["M"])) {
		echo "Set N(left) and M(right) please.";
		return;
	}

	$left = $_GET["N"];
	$right = $_GET["M"];

	$graph["N"] = $left;
	$graph["M"] = $right;
	$graph["E"] = array();

	$leftEdgeCount = array(0,0,0,0,0,0,0,0,0,0,0);
	$rightEdgeCount = array(0,0,0,0,0,0,0,0,0,0,0);

	for($i = 0; $i < $left; $i++){
		for($j = 0; $j < $right; $j++){
			if ((rand(0,2) == 0) && ($leftEdgeCount[$i] < 2) && ($rightEdgeCount[$j] < 2)){
				$weight = rand(1,20);
				$edge = array($i, $j, $weight);
				array_push($graph["E"], $edge);
				$leftEdgeCount[$i]++;
				$rightEdgeCount[$j]++;
			}
		}
	}

	echo json_encode($graph);
}

function solveGraph() {
	if (!isset($_GET["graph"])) {
		echo "Please specify the current graph!";
		return;
	}
	$h = new Hungarian($_GET["graph"]);
	echo $h->solve();
}


?>