<?php

class FileUploader {
    private $uploadDir;

    public function __construct($uploadDir) {
        $this->uploadDir = $uploadDir;
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    public function upload($file) {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Ошибка загрузки файла.');
        }

        $uniqueFileName = $this->generateUniqueFileName($file['name']);
        $destination = $this->uploadDir . DIRECTORY_SEPARATOR . $uniqueFileName;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return $uniqueFileName;
        } else {
            throw new Exception('Не удалось переместить загруженный файл.');
        }
    }

    private function generateUniqueFileName($originalName) {
        $ext = pathinfo($originalName, PATHINFO_EXTENSION);
        $uniqueName = uniqid('', true) . '.' . $ext;
        return $uniqueName;
    }
}