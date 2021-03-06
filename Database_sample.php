<?php 
class Database {
	private $pdo = null;
	private $queryTimeElapsed = 0;

	public function __construct() {
		$host = '127.0.0.1';
		$db   = 'bipartite_matching_game';
		$user = 'root';
		$pass = '';
		$charset = 'utf8';

		$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
		$opt = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => false,
		];
		$this->pdo = new PDO($dsn, $user, $pass, $opt);
	}

	public function __destruct() {
		// close connection
		$this->pdo = null;
	}

	public function getElapsedTime() {
		return $this->queryTimeElapsed;
	}

	public function login($user_id, $password, &$feedback) {
		$start = microtime(true);
			$stmt = $this->pdo->query('SELECT * FROM user WHERE user_id = "'.$user_id.'"')->fetchAll();
		$end = microtime(true);
		$this->queryTimeElapsed += $end-$start;

		if (count($stmt) != 1) {
			$feedback = "User ID not found";
			return -1;
		}
		if ($stmt[0]["hashed_password"] == crypt($password, $stmt[0]["hashed_password"])) {
			return $stmt[0]["role"];
		}
		$feedback = "Wrong password";
		return -1;
	}

	public function submitScore($graphId, $username, $numMatch, $totalScore, $elapsed) {
		$nowFormat = date('Y-m-d H:i:s');
		$start = microtime(true);
			$sql = "INSERT INTO score_table (graph_id,name,num_match,match_score,duration,date) VALUES (?,?,?,?,?,?)";
			$this->pdo->prepare($sql)->execute([$graphId, $username, $numMatch, $totalScore, $elapsed, $nowFormat]);
		$end = microtime(true);
		$this->queryTimeElapsed += $end-$start;
	}

	public function getAllUsers() {
		$start = microtime(true);
			$stmt = $this->pdo->query('SELECT * FROM user ORDER BY user_id')->fetchAll();
		$end = microtime(true);
		$this->queryTimeElapsed += $end-$start;
		return $stmt;
	}

	public function getBestScore($graphId) {
		$start = microtime(true);
			$stmt = $this->pdo->query('SELECT * FROM score_table WHERE graph_id = '.$graphId.' ORDER BY num_match DESC, match_score DESC, duration LIMIT 1')->fetchAll();
		$end = microtime(true);
		$this->queryTimeElapsed += $end-$start;

		if (count($stmt) == 0) return null;
		return $stmt[0];
	}

	public function getTop10Score($graphId) {
		$start = microtime(true);
			$stmt = $this->pdo->query('SELECT * FROM score_table WHERE graph_id = '.$graphId.' ORDER BY num_match DESC, match_score DESC, duration LIMIT 10')->fetchAll();
		$end = microtime(true);
		$this->queryTimeElapsed += $end-$start;
		return $stmt;
	}

	public function resetHighScore($user_id) {
		$start = microtime(true);
			$stmt = $this->pdo->query('SELECT * FROM user WHERE user_id = "'.$user_id.'"')->fetchAll();
		$end = microtime(true);
		$this->queryTimeElapsed += $end-$start;

		if (count($stmt) != 1) return false;
		if ($stmt[0]["role"] != 0) return false;

		$start = microtime(true);
			$sql = "TRUNCATE TABLE score_table";
			$this->pdo->prepare($sql)->execute();
		$end = microtime(true);
		$this->queryTimeElapsed += $end-$start;
	}

	public function registerUser($username, $email, $password, $confirm_password, &$feedback) {
		if ($password != $confirm_password) {
			$feedback = "Passwords do not match!";
			return false;
		}
		if (strlen($password) < 4) {
			$feedback = "Passwords must be at least 4 characters!";
			return false;
		}

		$start = microtime(true);
			$stmt = $this->pdo->query('SELECT * FROM user WHERE user_id = "'.$username.'"')->fetchAll();
		$end = microtime(true);
		$this->queryTimeElapsed += $end-$start;

		if (count($stmt) > 0) {
			$feedback = "Username is already taken!";
			return false;
		}

		$start = microtime(true);
			$sql = "INSERT INTO user (user_id,hashed_password,role,email) VALUES (?,?,?,?)";
			$this->pdo->prepare($sql)->execute([$username, crypt($password), 1, $email]);
			$feedback = "Registration Successful!";
		$end = microtime(true);
		$this->queryTimeElapsed += $end-$start;

		return true;
	}

};
?>