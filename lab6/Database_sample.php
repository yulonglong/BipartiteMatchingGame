<?php 
class Database {
	public $pdo = null;

	public function __construct() {
		$host = '127.0.0.1';
		$db   = 'score_database';
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

	public function login($user_id, $password) {
		$stmt = $this->pdo->query('SELECT * FROM user WHERE user_id = "'.$user_id.'"')->fetchAll();
		if (count($stmt) != 1) return -1;
		if ($stmt[0]["hashed_password"] == crypt($password, $stmt[0]["hashed_password"])) {
			return $stmt[0]["role"];
		}
		return -1;
	}

	public function getAllUsers() {
		$stmt = $this->pdo->query('SELECT * FROM user ORDER BY user_id')->fetchAll();
		return $stmt;
	}

	public function getBestScore($graphId) {
		$stmt = $this->pdo->query('SELECT * FROM score_table WHERE graph_id = '.$graphId.' ORDER BY num_match DESC, match_score DESC, duration LIMIT 1')->fetchAll();
		if (count($stmt) == 0) return null;
		return $stmt[0];
	}
};
?>