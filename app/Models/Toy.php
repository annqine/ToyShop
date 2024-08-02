<?php
require_once __DIR__ . '/../Core/Model.php';

class Toy extends Model
{
    public function dd($value)
    {
        echo '<pre>';
        print_r($value);
        echo '</pre>';
        die();
    }
    public function getAllToys($category = null, $query = null, $page = 1, $rows = 10, $sidx = 'id', $sord = 'asc')
    {
        $offset = ($page - 1) * $rows;

        // Основной запрос для получения данных
        $sql = "SELECT t.*, CONCAT('/images/', i.filename) AS photo_url 
            FROM all_toys t
            LEFT JOIN images i ON t.id_photo = i.id";

        // Условия фильтрации по категории и запросу
        $conditions = [];
        $params = [];

        if ($category !== null && $category != 0) {
            $conditions[] = "t.category = :category";
            $params[':category'] = $category;
        }

        if ($query !== null && $query !== '') {
            $conditions[] = "t.name_toys LIKE :query";
            $params[':query'] = '%' . $query . '%';
        }

        if (count($conditions) > 0) {
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }

        // Подсчет общего количества записей
        $countSql = "SELECT COUNT(*) AS total 
                 FROM all_toys t";

        if (count($conditions) > 0) {
            $countSql .= ' WHERE ' . implode(' AND ', $conditions);
        }

        $countStmt = $this->db->prepare($countSql);

        foreach ($params as $param => $value) {
            $countStmt->bindValue($param, $value);
        }

        if ($countStmt->execute()) {
            $totalRecords = $countStmt->fetchColumn();
        } else {
            error_log("SQL Error: " . print_r($countStmt->errorInfo(), true));
            $totalRecords = 0;
        }
        // Добавление сортировки и пагинации
        $sql .= " ORDER BY $sidx $sord LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);

        foreach ($params as $param => $value) {
            $stmt->bindValue($param, $value);
        }
        $stmt->bindValue(':limit', $rows, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            error_log("SQL Error: " . print_r($stmt->errorInfo(), true));
            $data = [];
        }
        //$this->dd($data);
        //$this->dd($totalRecords);
        // Возвращение данных и общего количества записей
        return [
            'data' => $data,
            'total' => $totalRecords
        ];
    }

    // // Получение всех игрушек с учетом категории и поиска по запросу
    // public function getAllToys($category = null, $query = null)
    // {
    //     $sql = "SELECT t.*, CONCAT('/images/', i.filename) AS photo_url 
    //             FROM all_toys t
    //             LEFT JOIN images i ON t.id_photo = i.id";

    //     // Добавление условий фильтрации по категории и запросу
    //     $conditions = [];
    //     $params = [];

    //     if ($category !== null && $category != 0) {
    //         $conditions[] = "t.category = :category";
    //         $params[':category'] = $category;
    //     }

    //     if ($query !== null && $query !== '') {
    //         $conditions[] = "t.name_toys LIKE :query";
    //         $params[':query'] = '%' . $query . '%';
    //     }

    //     if (count($conditions) > 0) {
    //         $sql .= ' WHERE ' . implode(' AND ', $conditions);
    //     }

    //     $stmt = $this->db->prepare($sql);

    //     foreach ($params as $param => $value) {
    //         $stmt->bindValue($param, $value);
    //     }

    //     if ($stmt->execute()) {
    //         $this->dd($stmt);
    //         return $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     } else {
    //         error_log("SQL Error: " . print_r($stmt->errorInfo(), true)); // Логирование ошибки SQL
    //         return false;
    //     }
    // }
    // Получение всех игрушек с учетом категории
    // public function getAllToys($category = null)
    // {
    //     $query = "SELECT t.*, CONCAT('/images/', i.filename) AS photo_url 
    //               FROM all_toys t
    //               LEFT JOIN images i ON t.id_photo = i.id";

    //     // Добавляем условие фильтрации по категории, если оно задано и не равно 0
    //     if ($category !== null && $category != 0) {
    //         $query .= " WHERE t.category = :category";
    //     }

    //     $stmt = $this->db->prepare($query);

    //     if ($category !== null && $category != 0) {
    //         $stmt->bindParam(':category', $category, PDO::PARAM_INT);
    //     }

    //     if ($stmt->execute()) {
    //         $this->dd($stmt);
    //         return $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     } else {
    //         error_log("SQL Error: " . print_r($stmt->errorInfo(), true)); // Логирование ошибки SQL
    //         return false;
    //     }
    // }


    // Загрузка изображения
    private function uploadImage($file)
    {
        $uploader = new FileUploader(__DIR__ . '/../../images');
        $uploadedFileName = $uploader->upload($file);
        $q = "INSERT INTO images (`filename`) VALUES (:filename)";
        $stmt = $this->db->prepare($q);
        $stmt->bindParam(':filename', $uploadedFileName, PDO::PARAM_STR);
        $stmt->execute();

        $q = "SELECT id FROM images WHERE filename = :filename";
        $stmt = $this->db->prepare($q);
        $stmt->bindParam(':filename', $uploadedFileName, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['id'];
    }

    // Добавление новой игрушки
    public function add($name, $price, $category, $file)
    {
        try {
            $imageId = $this->uploadImage($file);

            $q = "INSERT INTO all_toys (name_toys, available, id_photo, price, category) 
                  VALUES (:name, 1, :imageId, :price, :category)";
            $stmt = $this->db->prepare($q);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_STR);
            $stmt->bindParam(':imageId', $imageId, PDO::PARAM_INT);
            $stmt->bindParam(':category', $category, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            echo 'Ошибка: ' . $e->getMessage();
        }
    }

    // Редактирование существующей игрушки
    public function edit($id, $name, $price, $category, $file = null)
    {
        $q = "SELECT * FROM all_toys WHERE id = :id";
        $stmt = $this->db->prepare($q);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetch(PDO::FETCH_ASSOC);

        $imageId = $r['id_photo'];
        $imageIdOld = $imageId;
        $imageFilenameOld = $r['filename'];

        if ($file) {
            $imageId = $this->uploadImage($file);
        }

        $q = "UPDATE all_toys SET name_toys = :name, price = :price, category = :category, id_photo = :imageId WHERE id = :id";
        $stmt = $this->db->prepare($q);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':category', $category, PDO::PARAM_INT);
        $stmt->bindParam(':imageId', $imageId, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($file) {
            $q = "DELETE FROM images WHERE id = :imageIdOld";
            $stmt = $this->db->prepare($q);
            $stmt->bindParam(':imageIdOld', $imageIdOld, PDO::PARAM_INT);
            $stmt->execute();
            unlink(realpath(__DIR__ . '/../../images/' . $imageFilenameOld));
        }
    }

    // Удаление игрушки
    public function remove($id)
    {
        $q = "SELECT * FROM all_toys WHERE id = :id";
        $stmt = $this->db->prepare($q);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        $imageId = $r['id_photo'];

        $q = "DELETE FROM all_toys WHERE id = :id";
        $stmt = $this->db->prepare($q);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $q = "SELECT * FROM images WHERE id = :imageId";
        $stmt = $this->db->prepare($q);
        $stmt->bindParam(':imageId', $imageId, PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        $imageFilename = $r['filename'];

        unlink(__DIR__ . '/../../images/' . $imageFilename);

        $q = "DELETE FROM images WHERE id = :imageId";
        $stmt = $this->db->prepare($q);
        $stmt->bindParam(':imageId', $imageId, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Поиск игрушек по запросу
    // public function searchToys($query)
    // {
    //     $query = "%" . $query . "%";
    //     $sql = "SELECT t.*, CONCAT('/images/', i.filename) AS photo_url 
    //             FROM all_toys t
    //             LEFT JOIN images i ON t.id_photo = i.id
    //             WHERE t.name_toys LIKE :query";

    //     $stmt = $this->db->prepare($sql);
    //     $stmt->bindParam(':query', $query, PDO::PARAM_STR);

    //     if ($stmt->execute()) {
    //         return $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     } else {
    //         error_log("SQL Error: " . print_r($stmt->errorInfo(), true));
    //         return false;
    //     }
    // }
}
?>