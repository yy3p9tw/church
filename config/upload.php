<?php
class FileUpload {
    private $rootDir;      // 專案根目錄的絕對路徑 (含結尾分隔符)
    private $uploadRel;    // 上傳目錄的相對路徑（如 public/uploads/）以斜線結尾
    private $allowedTypes;
    private $maxSize;
    private $lastError;
    
    public function __construct($uploadDir = 'public/uploads/', $allowedTypes = [], $maxSize = 10485760) {
        // 基底目錄：config/ 的上一層即專案根目錄
        $this->rootDir = rtrim(dirname(__DIR__), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        // 標準化相對路徑（使用正斜線並以斜線結尾）
        $this->uploadRel = rtrim(str_replace('\\', '/', $uploadDir), '/') . '/';
        $this->allowedTypes = $allowedTypes;
        $this->maxSize = $maxSize; // 預設10MB
        
        // 確保上傳目錄存在
        $this->ensureDirectoryExists($this->rootPath($this->uploadRel));
    }
    
    private function ensureDirectoryExists($dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }
    
    public function upload($file, $subDir = '') {
        if (!$this->validateFile($file)) {
            return false;
        }
        
        $fileName = $this->generateFileName($file['name']);
        $targetRelDir = $this->uploadRel . ($subDir ? rtrim(str_replace('\\', '/', $subDir), '/') . '/' : '');
        $targetAbsDir = $this->rootPath($targetRelDir);
        $this->ensureDirectoryExists($targetAbsDir);

        $targetAbsPath = $targetAbsDir . $fileName;
        
        if (move_uploaded_file($file['tmp_name'], $targetAbsPath)) {
            $relPath = $targetRelDir . $fileName; // 例如 public/uploads/news/xxx.jpg
            return [
                'success' => true,
                'filename' => $fileName,
                // 相對於專案根目錄的路徑（維持現有呼叫端習慣）
                'path' => str_replace('\\', '/', $relPath),
                // 絕對檔案系統路徑（供需要時使用）
                'abs_path' => $targetAbsPath,
                // 網址路徑（盡量使用 / 開頭的相對根路徑）
                'url' => '/' . str_replace('\\', '/', $relPath)
            ];
        }
        
        return false;
    }

    private function rootPath($relative) {
        // 將 public/... 相對路徑轉為檔案系統絕對路徑
        $relative = ltrim(str_replace('\\', '/', $relative), '/');
        $abs = $this->rootDir . str_replace('/', DIRECTORY_SEPARATOR, $relative);
        // 確保目錄路徑以分隔符結尾（用於資料夾）
        if (substr($abs, -1) !== DIRECTORY_SEPARATOR) {
            $abs .= DIRECTORY_SEPARATOR;
        }
        return $abs;
    }
    
    private function validateFile($file) {
        // 檢查是否有錯誤
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $this->lastError = $this->getUploadError($file['error']);
            return false;
        }
        
        // 檢查檔案大小
        if ($file['size'] > $this->maxSize) {
            $this->lastError = '檔案太大，最大允許 ' . $this->formatBytes($this->maxSize);
            return false;
        }
        
        // 檢查檔案類型
        if (!empty($this->allowedTypes)) {
            $fileType = mime_content_type($file['tmp_name']);
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            
            if (!in_array($fileType, $this->allowedTypes) && 
                !in_array($extension, $this->allowedTypes)) {
                $this->lastError = '不支援的檔案類型';
                return false;
            }
        }
        
        return true;
    }
    
    private function generateFileName($originalName) {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        return uniqid() . '_' . time() . '.' . $extension;
    }
    
    private function getUploadError($errorCode) {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                return '檔案太大（超過 php.ini 限制）';
            case UPLOAD_ERR_FORM_SIZE:
                return '檔案太大（超過表單限制）';
            case UPLOAD_ERR_PARTIAL:
                return '檔案只上傳了一部分';
            case UPLOAD_ERR_NO_FILE:
                return '沒有檔案被上傳';
            case UPLOAD_ERR_NO_TMP_DIR:
                return '找不到臨時目錄';
            case UPLOAD_ERR_CANT_WRITE:
                return '檔案寫入失敗';
            case UPLOAD_ERR_EXTENSION:
                return 'PHP 擴展停止了檔案上傳';
            default:
                return '未知錯誤';
        }
    }
    
    private function formatBytes($bytes) {
        $units = array('B', 'KB', 'MB', 'GB');
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, 2) . ' ' . $units[$pow];
    }
    
    public function getLastError() {
        return $this->lastError ?? '';
    }
    
    public function deleteFile($filePath) {
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        return false;
    }
}

// 預定義上傳配置
class ImageUpload extends FileUpload {
    public function __construct($uploadDir = 'public/uploads/events/') {
        $allowedTypes = [
            'image/jpeg', 'image/png', 'image/gif', 'image/webp',
            'jpg', 'jpeg', 'png', 'gif', 'webp'
        ];
        parent::__construct($uploadDir, $allowedTypes, 5242880); // 5MB
    }
}

class AudioUpload extends FileUpload {
    public function __construct($uploadDir = 'public/uploads/audio/') {
        $allowedTypes = [
            'audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/m4a',
            'mp3', 'wav', 'm4a'
        ];
        parent::__construct($uploadDir, $allowedTypes, 52428800); // 50MB
    }
}
