<?php
// Maximum Weighted Bipartite Matching
// Hungarian Algorithm

define("MAX_N", 50);
define("INFINITY", 10000000);

// Test code to test and debug the algorithm
// $json = '{"N":"4","M":"5","E":[[0,3,20],[2,3,6],[3,0,17],[3,1,8]]}';
// $h = new Hungarian($json);
// echo $h->solve();

class Hungarian {
	// To keep track of the edges chosen in the answer, set to true to save all edges
	private $showGraphAnswer = false;

	private $cost = array(); //cost matrix
	private $n;
	private $max_match; //n workers and n jobs
	private $lx = array(); 
	private $ly = array(); //labels of X and Y parts
	private $xy = array(); //xy[x] - vertex that is matched with x,
	private $yx = array(); //yx[y] - vertex that is matched with y
	private $S = array();
	private $T = array(); //sets S and T in algorithm
	private $slack = array(); //as in the algorithm description
	private $slackx = array(); //slackx[y] such a vertex, that l(slackx[y]) + l(y) - w(slackx[y],y) = slack[y]
	private $pprev = array(); //array for memorizing alternating paths

	public function __construct($jsonArray, $_showGraphAnswer = false) {
		$this->showGraphAnswer = $_showGraphAnswer;

		$phpArray = json_decode($jsonArray, true);

		$this->n = max($phpArray["N"],$phpArray["M"]);

		for($i = 0; $i < $this->n; $i++) {
			for($j = 0; $j < $this->n; $j++) {
				$this->cost[$i][$j] = -INFINITY;
			}
		}
		foreach ($phpArray["E"] as $edge) {
			$this->cost[$edge[0]][$edge[1]] = $edge[2];
		}

		$this->max_match = 0;
		for($i = 0; $i < $this->n; $i++) {
			$this->xy[$i] = -1;
			$this->yx[$i] = -1;
			$this->lx[$i] = 0;
			$this->ly[$i] = 0;
		}

		for($i = 0; $i < $this->n; $i++) {
			for($j = 0; $j < $this->n; $j++) {
				$this->lx[$i] = max($this->lx[$i], $this->cost[$i][$j]);
			}
		}
	}


	private function updateLabels() {
		$x = 0;
		$y = 0;
		$delta = INFINITY; //init delta as infinity
		for ($y = 0; $y < $this->n; $y++) { //calculate delta using slack
			if (!$this->T[$y]) {
				$delta = min($delta, $this->slack[$y]);
			}
		}
		for ($x = 0; $x < $this->n; $x++) { //update X labels
			if ($this->S[$x]) {
				$this->lx[$x] -= $delta;
			}
		}
		for ($y = 0; $y < $this->n; $y++) { //update Y labels
			if ($this->T[$y]) {
				$this->ly[$y] += $delta;
			}
		}

		for ($y = 0; $y < $this->n; $y++) { //update slack array
			if (!$this->T[$y]) {
				$this->slack[$y] -= $delta;
			}
		}
	}

	private function addToTree($x, $pprevx) {
		//x - current vertex,pprevx - vertex from X before x in the alternating path,
		//so we add edges (pprevx, xy[x]), (xy[x], x)
		$this->S[$x] = true; //add x to S
		$this->pprev[$x] = $pprevx; //we need this when augmenting
		for ($y = 0; $y < $this->n; $y++) { //update slacks, because we add new vertex to S
			if ($this->lx[$x] + $this->ly[$y] - $this->cost[$x][$y] < $this->slack[$y]) {
				$this->slack[$y] = $this->lx[$x] + $this->ly[$y] - $this->cost[$x][$y];
				$this->slackx[$y] = $x;
			}
		}
	}

	private function augment() {
		if ($this->max_match == $this->n) return; // check whether matching is prefect
		$x; $y; $root; // counters and root vertex
		$q = array(); // queue for bfs
		$wr = 0; $rd = 0; // write and read
		for ($i = 0; $i < $this->n; $i++) { // initialize
			$this->S[$i] = false;
			$this->T[$i] = false;
			$this->pprev[$i] = -1;
		}
		for ($x = 0; $x < $this->n; $x++) { // find the root of the tree
			if ($this->xy[$x] == -1) {
				$q[$wr++] = $root = $x;
				$this->pprev[$x] = -2;
				$this->S[$x] = true;
				break;
			}
		}
		for ($y = 0; $y < $this->n; $y++) { // initializing slack array
			$this->slack[$y] = $this->lx[$root] + $this->ly[$y] - $this->cost[$root][$y];
			$this->slackx[$y] = $root;
		}

		// second part
		while (true) {
			while ($rd < $wr) { // build tree with bfs cycle
				$x = $q[$rd++]; // current vertex
				for ($y = 0; $y < $this->n; $y++) { // iterate all edges in equality graph
					if (($this->cost[$x][$y] == $this->lx[$x] + $this->ly[$y]) && (!$this->T[$y])) {
						if ($this->yx[$y] == -1) break; // exposed vertex in Y found, augmenting path exists
						$this->T[$y] = true; // add y to T
						$q[$wr++] = $this->yx[$y]; // add vertex yx[y], matched with y into the queue
						$this->addToTree($this->yx[$y], $x);
					}
				}
				if ($y < $this->n) break; // augmenting path found
			}
			if ($y < $this->n) break; // augmenting path found

			$this->updateLabels(); // augmenting path not found, improve labeling

			$wr = $rd = 0;
			for ($y = 0; $y < $this->n; $y++) {
				// in this cycle we add edges that were added to the equality graph as a
				// result of improving the labeling, we add edge (slackx[y], y) to the tree if
				// and only if !T[y] && slack[y] == 0, also with this edge we add another one
				// (y, yx[y]) or augment the matching, if y was exposed
				if ((!$this->T[$y]) && ($this->slack[$y] == 0)) {
					if ($this->yx[$y] == -1) { //exposed vertex in Y found - augmenting path exists!
						$x = $this->slackx[$y];
						break;
					}
					else {
						$this->T[$y] = true; //else just add y to T,
						if (!$this->S[$this->yx[$y]]) {
							$q[$wr++] = $this->yx[$y]; //add vertex yx[y], which is matched with y, to the queue
							$this->addToTree($this->yx[$y], $this->slackx[$y]); //and add edges (x,y) and (y, yx[y]) to the tree
						}
					}
				}
			}
			if ($y < $this->n) break; // augmenting path found
		}

		if ($y < $this->n) { //we found augmenting path!
			$this->max_match++; //increment matching
			//in this cycle we inverse edges along augmenting path
			$cx = $x;
			$cy = $y;
			$ty = 0;
			while ($cx != -2) {
				$ty = $this->xy[$cx];
				$this->yx[$cy] = $cx;
				$this->xy[$cx] = $cy;

				$cx = $this->pprev[$cx];
				$cy = $ty;
			}
			$this->augment(); //recall function, go to step 1 of the algorithm
		}

	}

	public function solve() {
		$this->augment();

		$totalMatch = 0;
		$totalScore = 0;
		$answerArray = array();
		$answerArray["match"] = array();

		for($i = 0; $i < $this->n; $i++) {
			$currentCost = $this->cost[$i][$this->xy[$i]];
			if ($currentCost != -INFINITY) {
				$totalMatch++;
				$totalScore += $currentCost;
				$edge = array($i, $this->xy[$i]);
				if ($this->showGraphAnswer) array_push($answerArray["match"], $edge);
			}
			// echo $i."->".$this->xy[$i]." : ".$this->cost[$i][$this->xy[$i]]."<br>";
		}
		$answerArray["num_match"] = $totalMatch;
		$answerArray["match_score"] = $totalScore;

		return json_encode($answerArray);
	}
}

?>