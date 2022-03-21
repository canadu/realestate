<?php
//vendorディレクトリの階層を指定する
require __DIR__ . '/../../vendor/autoload.php';

class DataSource
{
    public PDO $conn;
    private string $dbHost;
    private string $dbUsername;
    private string $dbPassword;
    private string $dbDatabase;
    public const CLS = 'cls';

    public function __construct()
    {
        //.envの階層を指定する
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
        $this->dbHost = $_ENV['DB_HOST'];
        $this->dbUsername = $_ENV['DB_USERNAME'];
        $this->dbPassword = $_ENV['DB_PASSWORD'];
        $this->dbDatabase = $_ENV['DB_DATABASE'];
        $dsn = "mysql:host=" . $this->dbHost . ";dbname=" . $this->dbDatabase . ";charset=utf8mb4";
        $this->conn = new PDO($dsn, $this->dbUsername, $this->dbPassword);
    }
}
