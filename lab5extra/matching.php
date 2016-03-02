<?php
session_start();

require_once("Hungarian.php");
require_once("Database.php");

// Graph Test case class to store logical test cases
class GraphTestCase {
	public $jsonArray = array(
		'{"N":2,"M":2,"E":[[0,0,1],[0,1,1],[1,0,1]]}',
		'{"N":3,"M":3,"E":[[0,0,1],[0,1,1],[1,0,1],[2,0,5],[1,2,3],[2,2,2]]}',
		'{"N":4,"M":4,"E":[[1,0,5],[1,1,5],[2,2,18],[3,0,3],[3,2,14]]}',
		'{"N":5,"M":5,"E":[[1,1,5],[1,3,12],[2,0,19],[2,2,14],[3,2,19],[3,3,6],[4,0,8],[4,4,20]]}',
		'{"N":6,"M":6,"E":[[0,0,1],[1,2,9],[1,5,8],[2,0,8],[2,3,2],[3,2,5],[4,1,16],[5,4,18],[5,5,15]]}',
		'{"N":7,"M":7,"E":[[0,0,15],[0,6,10],[1,0,7],[1,3,20],[2,2,8],[3,1,10],[4,1,19],[4,3,9],[4,5,11],[5,4,2],[5,5,5],[5,6,7]]}',
		'{"N":8,"M":8,"E":[[0,0,7],[0,1,12],[1,0,6],[1,1,10],[1,2,13],[2,2,4],[2,3,1],[3,1,17],[3,3,11],[3,4,14],[4,3,4],[4,7,20],[5,4,4],[5,6,14],[6,5,1],[6,7,6],[7,7,16]]}',
		'{"N":9,"M":9,"E":[[0,0,11],[0,4,3],[1,0,17],[1,2,7],[2,1,7],[2,2,13],[2,4,5],[3,3,10],[3,5,9],[4,5,17],[4,6,7],[5,2,18],[5,5,13],[5,6,3],[6,6,9],[6,7,11],[7,7,7],[7,8,9],[8,8,4],[8,6,14]]}',
		'{"N":10,"M":10,"E":[[0,0,5],[0,8,14],[1,0,11],[1,1,6],[2,4,8],[2,0,7],[2,2,10],[2,3,10],[3,3,7],[3,4,20],[4,2,12],[4,5,7],[4,6,7],[5,5,17],[5,6,1],[6,4,4],[6,6,10],[6,8,5],[6,9,6],[7,7,1],[7,8,3],[8,7,4],[8,8,9],[9,8,5],[9,9,8]]}'
	);

	public function __construct() {
	}
};




if (!isset($_GET["cmd"])) {
	echo "Please specify command!";
	return;
}

$cmd = $_GET["cmd"];

if ($cmd == "generate") generateGraph();
else if ($cmd == "solve") solveGraph();
else if ($cmd == "submit") submitGraph();
else if ($cmd == "highscore") getHighscore();
else {
	echo "Sorry, command is not supported!";
	return;
}

function generateGraph() {
    if ((!isset($_GET["N"]) || !isset($_GET["M"])) && (!isset($_GET["graph_id"]))) {
		echo "Set N(left) and M(right) please. Or specify a graph_id.";
		return;
	}

	if (isset($_GET["graph_id"])) {
		$graphId = $_GET["graph_id"];
		echo generateGraphById($graphId);
	}
	else if (isset($_GET["N"]) && isset($_GET["M"])) {
		$left = $_GET["N"];
		$right = $_GET["M"];
		echo generateRandomGraph($left,$right);
	}
	else {
		echo "Set N(left) and M(right) please. Or specify a graph_id.";
	}

}

function generateRandomGraph($left, $right) {
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
	return json_encode($graph);
}

function generateGraphById($graphId) {
	// Check whether competitive session already started
	if (!isset($_SESSION['start'])) { /* or use !isset */
		$_SESSION['start'] = 1;
		$_SESSION['graph_id'] = $graphId;
		$_SESSION['visittime'] = time();
	}
	// if already started, check graph_id, if it's the same graph_id, do not update any session variables
	else if (isset($_SESSION['graph_id'])) {
		if ($_SESSION['graph_id'] != $graphId) {
			$_SESSION['start'] = 1;
			$_SESSION['graph_id'] = $graphId;
			$_SESSION['visittime'] = time();
		}
	}

	$tc = new GraphTestCase();
	return $tc->jsonArray[$graphId-1];
}


function solveGraph() {
	if (isset($_GET["graph_id"])) {
		$graphId = $_GET["graph_id"];
		if (($graphId < 1) || ($graphId > 9)) {
			echo "invalid graph ID!";
			return;
		}

		$tc = new GraphTestCase();
		$currGraphJson = $tc->jsonArray[$graphId-1];
		$h = new Hungarian($currGraphJson, false);
		echo $h->solve();
	}
	else if (isset($_GET["graph"])) {
		$h = new Hungarian($_GET["graph"], true);
		echo $h->solve();
	}
	else {
		echo "Please specify the current graph!";
		return;
	}
}

function submitGraph() {
	if ((isset($_GET["graph_id"])) &&  (isset($_GET["solution"]))) {
		$graphId = $_GET["graph_id"];
		if (($graphId < 1) || ($graphId > 9)) {
			echo "invalid graph ID!";
			return;
		}

		$username = "Anonymous";
		if (isset($_GET["username"])) $username = $_GET["username"];

		$tc = new GraphTestCase();
		$currGraphJson = $tc->jsonArray[$graphId-1];
		$currGraph = json_decode($currGraphJson, true);

		$solutionArray = json_decode($_GET["solution"], true);
		// echo var_dump($solutionArray);

		$totalScore = 0;
		$numMatch = count($solutionArray);

		foreach ($solutionArray as $solutionEdge) {
			$solutionLeft = $solutionEdge[0];
			$solutionRight = $solutionEdge[1];
			$valid = false;
			foreach ($currGraph["E"] as $edge) {
				$left = $edge[0];
				$right = $edge[1];
				if (($solutionLeft == $left) && ($solutionRight == $right)) {
					$totalScore = $totalScore + $edge[2];
					$valid = true;
				}
			}
			if (!$valid) {
				echo "edge (".$solutionLeft.",".$solutionRight.") is invalid!";
				return;
			}
		}

		// echo $totalScore;


		if ((isset($_SESSION['start'])) && (isset($_SESSION['graph_id'])) && ($_SESSION['graph_id'] == $graphId)) { /* or use !isset */
			$_SESSION['start'] = 0;
			$_SESSION['graph_id'] = 0;
			$elapsed = time()-$_SESSION['visittime'];
		}
		else {
			echo "Invalid Session, please reset and try again!";
			return;
		}

		$highscoreArray = array();
		$highscoreArray["graph_id"] = $graphId;
		$highscoreArray["duration"] = $elapsed;

		$database = new Database();

		$stmt = $database->pdo->query('SELECT * FROM highscore_table WHERE graph_id = '.$graphId.' ORDER BY num_match DESC, match_score DESC, duration LIMIT 10')->fetchAll();
		// echo var_dump($stmt);

		// if nobody never played this graph_id yet
		if (count($stmt) == 0) {
			$nowFormat = date('Y-m-d H:i:s');
			$sql = "INSERT INTO highscore_table (graph_id,name,num_match,match_score,duration,date) VALUES (?,?,?,?,?,?)";
			$database->pdo->prepare($sql)->execute([$graphId, $username, $numMatch, $totalScore, $elapsed, $nowFormat]);

			$highscoreArray["num_match"] = $numMatch;
			$highscoreArray["match_score"] = $totalScore;
			$highscoreArray["best_duration"] = $elapsed;
			$highscoreArray["new_best"] = 1;
		}
		else {
			// echo $numMatch." -- ".$stmt[0]["num_match"]."<br>";
			// echo $totalScore." -- ".$stmt[0]["match_score"]."<br>";

			$newHighscore = false;
			if ($numMatch > $stmt[0]["num_match"]) $newHighscore = true;
			else if (($numMatch == $stmt[0]["num_match"]) && ($totalScore > $stmt[0]["match_score"])) $newHighscore = true;
			else if (($numMatch == $stmt[0]["num_match"]) && ($totalScore == $stmt[0]["match_score"]) && ($elapsed < $stmt[0]["duration"])) $newHighscore = true;

			if ($newHighscore) {
				$highscoreArray["num_match"] = $numMatch;
				$highscoreArray["match_score"] = $totalScore;
				$highscoreArray["best_duration"] = $elapsed;
				$highscoreArray["new_best"] = 1;
			}
			else {
				$highscoreArray["num_match"] = $stmt[0]["num_match"];
				$highscoreArray["match_score"] = $stmt[0]["match_score"];
				$highscoreArray["best_duration"] = $stmt[0]["duration"];
				$highscoreArray["new_best"] = 0;
			}

			$nowFormat = date('Y-m-d H:i:s');
			$sql = "INSERT INTO highscore_table (graph_id,name,num_match,match_score,duration,date) VALUES (?,?,?,?,?,?)";
			$database->pdo->prepare($sql)->execute([$graphId, $username, $numMatch, $totalScore, $elapsed, $nowFormat]);

		}
		echo json_encode($highscoreArray);

	}
	else {
		echo "Wrong parameters for solution submission!";
		return;
	}
}

function getHighscore() {
	if (isset($_GET["graph_id"])) {
		$graphId = $_GET["graph_id"];
		if (($graphId < 1) || ($graphId > 9)) {
			echo "invalid graph ID!";
			return;
		}
		$database = new Database();
		$stmt = $database->pdo->query('SELECT * FROM highscore_table WHERE graph_id = '.$graphId.' ORDER BY num_match DESC, match_score DESC, duration LIMIT 10')->fetchAll();
		echo json_encode($stmt);
	}
	else {
		echo "Wrong parameters for get highscore!";
		return;
	}
}

?>