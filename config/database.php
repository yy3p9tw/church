<?php
// 資料庫配置
class Database {
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $pdo;
    
    public function __construct() {
        // 從環境變數或設定檔讀取資料庫配置
        $this->host = $_ENV['DB_HOST'] ?? 'localhost';
        $this->dbname = $_ENV['DB_NAME'] ?? 'church_db';
        $this->username = $_ENV['DB_USER'] ?? 'root';
        $this->password = $_ENV['DB_PASS'] ?? '';
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
                // 如果MySQL連接失敗，嘗試使用SQLite
                $this->connectSQLite();
            }
        }
        
        return $this->pdo;
    }
    
    public function isMySQL() {
        $this->connect();
        return $this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME) === 'mysql';
    }
    
    public function now() {
        return $this->isMySQL() ? 'NOW()' : "datetime('now')";
    }
    
    private function connectSQLite() {
        try {
            $sqliteFile = __DIR__ . '/../database/church.sqlite';
            
            // 如果SQLite檔案不存在，建立它
            if (!file_exists($sqliteFile)) {
                $this->createSQLiteDatabase($sqliteFile);
            }
            
            $this->pdo = new PDO("sqlite:$sqliteFile");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("資料庫連接失敗: " . $e->getMessage());
        }
    }
    
    private function createSQLiteDatabase($sqliteFile) {
        // 確保目錄存在
        $dir = dirname($sqliteFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        // 建立空的SQLite檔案
        $pdo = new PDO("sqlite:$sqliteFile");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // 建立資料表結構（SQLite版本）
        $this->createSQLiteTables($pdo);
        
        $this->pdo = $pdo;
    }
    
    private function createSQLiteTables($pdo) {
        $sql = "
        -- 管理員用戶表
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            role VARCHAR(50) DEFAULT 'admin',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        
        -- 最新消息表
        CREATE TABLE IF NOT EXISTS news (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title VARCHAR(255) NOT NULL,
            content TEXT NOT NULL,
            news_date DATE,
            image_url VARCHAR(255),
            status VARCHAR(20) DEFAULT 'published',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        
        -- 講道表
        CREATE TABLE IF NOT EXISTS sermons (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title VARCHAR(255) NOT NULL,
            speaker VARCHAR(255) NOT NULL,
            sermon_date DATE NOT NULL,
            youtube_url VARCHAR(500),
            youtube_id VARCHAR(50),
            content TEXT,
            status VARCHAR(20) DEFAULT 'published',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        
        -- 活動表
        CREATE TABLE IF NOT EXISTS events (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title VARCHAR(255) NOT NULL,
            start_time DATETIME NOT NULL,
            end_time DATETIME,
            location VARCHAR(255),
            content TEXT,
            status VARCHAR(20) DEFAULT 'published',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        
        -- 同工表
        CREATE TABLE IF NOT EXISTS staff (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(255) NOT NULL,
            title VARCHAR(255) NOT NULL,
            photo VARCHAR(255),
            bio TEXT,
            sort_order INTEGER DEFAULT 0,
            status INTEGER DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        
        -- 輪播圖表
        CREATE TABLE IF NOT EXISTS sliders (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title VARCHAR(255),
            image_url VARCHAR(255) NOT NULL,
            link_url VARCHAR(255),
            sort_order INTEGER DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        
        -- 聯絡訊息表
        CREATE TABLE IF NOT EXISTS contact_messages (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            phone VARCHAR(50),
            subject VARCHAR(255) NOT NULL,
            message TEXT NOT NULL,
            status VARCHAR(20) DEFAULT 'unread',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        
        -- 週報表
        CREATE TABLE IF NOT EXISTS bulletins (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title VARCHAR(255) NOT NULL,
            image_url VARCHAR(255),
            pdf_url VARCHAR(255),
            publish_date DATE,
            status VARCHAR(20) DEFAULT 'published',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        
        -- 插入初始管理員用戶
        INSERT OR IGNORE INTO users (name, email, password, role) 
        VALUES ('管理員', 'admin@church.com', '" . password_hash('admin123', PASSWORD_DEFAULT) . "', 'admin');
        
        -- 插入示例數據
        INSERT OR IGNORE INTO news (title, content, news_date) VALUES
        ('歡迎來到教會', '歡迎大家來到我們的教會網站，這裡有最新的教會消息和活動資訊。', '" . date('Y-m-d') . "'),
        ('聖誕節特別聚會', '12月25日將舉辦聖誕節特別聚會，歡迎弟兄姊妹踴躍參加。', '" . date('Y-m-d', strtotime('+30 days')) . "');
        
        INSERT OR IGNORE INTO sermons (title, speaker, sermon_date, content) VALUES
        ('神的愛與恩典', '王牧師', '" . date('Y-m-d', strtotime('-7 days')) . "', '這是一篇關於神的愛與恩典的講道內容。'),
        ('信心的力量', '李傳道', '" . date('Y-m-d', strtotime('-14 days')) . "', '這是一篇關於信心力量的講道內容。');
        
        INSERT OR IGNORE INTO events (title, start_time, location, content) VALUES
        ('主日崇拜', '" . date('Y-m-d H:i:s', strtotime('next Sunday 10:00')) . "', '主堂', '每週主日崇拜，歡迎參加。'),
        ('青年團契', '" . date('Y-m-d H:i:s', strtotime('next Friday 19:00')) . "', '青年活動室', '青年團契聚會，分享生活與信仰。');
        
        INSERT OR IGNORE INTO staff (name, title, bio, sort_order) VALUES
        ('王恩典', '主任牧師', '擁有神學碩士學位，在教會服事超過15年，致力於福音傳播和信徒造就。', 1),
        ('李喜樂', '副牧師', '負責青年事工和小組牧養，熱心於青年事工的發展。', 2),
        ('張平安', '長老', '教會創始成員之一，負責教會行政和財務管理工作。', 3);
        ";
        
        $pdo->exec($sql);
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
