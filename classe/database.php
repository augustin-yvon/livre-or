<?php
class Database {
    private $host = "localhost";
    private $dbname = "livreor";
    private $username = "root";
    private $password = "";
    public $pdo;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        // 2 syntaxes :
        // $this->pdo = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";port=3308", $this->username, $this->password);
        $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname};port=3308", $this->username, $this->password);
    }
    
    public function validateLogin($login) {
        $checkLoginQuery = "SELECT id FROM user WHERE login = :login";
        $stmt = $this->pdo->prepare($checkLoginQuery);
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        }
    }

    public function register($login, $password) {
        $registerQuery = "INSERT INTO user (login, password) VALUES (:login, :password)";
        $stmt = $this->pdo->prepare($registerQuery);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            return true;
        }
    }

    public function getId($login) {
        // Récupérer l'id à partir du login
        $selectIdQuery = "SELECT `id` FROM `user` WHERE `login` = :login";
        $stmt = $this->pdo->prepare($selectIdQuery);
        $stmt->bindParam(':login', $login);
        $stmt->execute();

        return $stmt->fetchColumn();
    }
}
?>