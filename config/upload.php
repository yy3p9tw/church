<?php
class FileUpload {
    private $uploadDir;
    private $allowedTypes;
    private $maxSize;
    
    public function __construct($uploadDir = 'public/uploads/', $allowedTypes = [], $maxSize = 10485760) {
        $this->uploadDir = rtrim($uploadDir, '/') . '/';
        $this->allowedTypes = $allowedTypes;
        $this->maxSize = $maxSize; // 預設10MB
        
        // 確保上傳目錄存在
        $this->ensureDirectoryExists($this->uploadDir);
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
        $targetDir = $this->uploadDir . ($subDir ? rtrim($subDir, '/') . '/' : '');
        $this->ensureDirectoryExists($targetDir);
        
        $targetPath = $targetDir . $fileName;
        
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return [
                'success' => true,
                'filename' => $fileName,
                'path' => $targetPath,
                'url' => str_replace($_SERVER['DOCUMENT_ROOT'], '', $targetPath)
            ];
        }
        
        return false;
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
    public function __construct($uploadDir = 'public/uploads/images/') {
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
