<?php

//vendorディレクトリの階層を指定する
require __DIR__ . '/../../vendor/autoload.php';

class DataSource
{
    private PDO $conn;
    private bool $sqlResult;
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

    //取得下データを返す
    /**
     *  @param string $sql
     *  @param array<mixed> $params
     *  @param string $type
     *  @param string $cls
     */
    public function select(string $sql = "", array $params = []): mixed
    {
        $stmt = $this->executeSql($sql, $params);
        return $stmt->fetchAll();
    }

    //取得したデータから１行取得
    /**
     *  @param string $sql
     *  @param array<mixed> $params
     *  @param string $type
     *  @param string $cls
     */

    public function selectOne(string $sql = "", array $params = []): mixed
    {
        $result = $this->select($sql, $params);
        return count($result) > 0 ? $result[0] : false;
    }

    //sql実行
    /**
     *  @param string $sql
     *  @param array<mixed> $params
     */
    public function execute(string $sql = "", array $params = []): bool
    {
        $this->executeSql($sql, $params);
        return  $this->sqlResult;
    }

    /**
     *  @param string $sql
     *  @param array<mixed> $params
     */
    private function executeSql(string $sql, array $params): PDOStatement
    {
        $stmt = $this->conn->prepare($sql);
        $this->sqlResult = $stmt->execute($params);
        return $stmt;
    }

    //トランザクション
    public function begin(): void
    {
        $this->conn->beginTransaction();
    }
    public function commit(): void
    {
        $this->conn->commit();
    }
    public function rollback(): void
    {
        $this->conn->rollback();
    }
}
