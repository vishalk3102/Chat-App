<?php
require 'bin\vendor\autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
class DatabaseConnection
{
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $conn;

    public function __construct()
    {
        $this->servername = $_ENV['DB_HOST'];
        $this->username = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASS'];
        $this->dbname = $_ENV['DB_NAME'];

    }
    public function connect()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=".$this->servername . ";dbname=" . $this->dbname, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>