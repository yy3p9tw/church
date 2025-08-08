<?php
// 資料庫配置
class Database {
    // 確保 .env 只載入一次
    private static $envLoaded = false;
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $pdo;
    
    public function __construct() {
        // 先嘗試載入 .env（若尚未載入）
        self::bootstrapEnv();
        // 從環境變數讀取資料庫配置
        $this->host = $_ENV['DB_HOST'] ?? 'localhost';
        $this->dbname = $_ENV['DB_NAME'] ?? 'church_db';
        $this->username = $_ENV['DB_USER'] ?? 'root';
        $this->password = $_ENV['DB_PASS'] ?? '';
    }

    // 載入專案根目錄的 .env
    private static function bootstrapEnv() {
        if (self::$envLoaded) return;
        $root = dirname(__DIR__); // 專案根目錄
        $envPath = $root . DIRECTORY_SEPARATOR . '.env';
        if (file_exists($envPath)) {
            $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if ($line === '' || $line[0] === '#') continue;
                if (strpos($line, '=') === false) continue;
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);
                if ((substr($value, 0, 1) === '"' && substr($value, -1) === '"') ||
                    (substr($value, 0, 1) === "'" && substr($value, -1) === "'")) {
                    $value = substr($value, 1, -1);
                }
                $_ENV[$key] = $value;
                putenv("$key=$value");
            }
        }
        self::$envLoaded = true;
    }
    
    public function connect() {
        if ($this->pdo === null) {
            try {
                $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];
                $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
            } catch (PDOException $e) {
                // 錯誤處理
                die("資料庫連接失敗：" . $e->getMessage());
            }
        }
        return $this->pdo;
    }
    
    // 取得當前時間（MySQL）
    public function now() {
        return 'NOW()';
    }
    
    public function query($sql, $params = []) {
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
    
    public function fetchAll($sql, $params = []) {
        return $this->query($sql, $params)->fetchAll();
    }
    
    public function fetchOne($sql, $params = []) {
        return $this->query($sql, $params)->fetch();
    }
    
    public function lastInsertId() {
        return $this->connect()->lastInsertId();
    }
}

// 全域資料庫實例
$db = new Database();
