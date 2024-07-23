<?php
require_once __DIR__ . '/../Core/Model.php';

class Toy extends Model
{
    public function getAllToys()
    {
        $query = "SELECT t.*, CONCAT('/images/', i.filename) AS photo_url 
          FROM all_toys t
          LEFT JOIN images i ON t.id_photo = i.id";

        $stmt = $this->db->prepare($query);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } else {
            error_log("SQL Error: " . print_r($stmt->errorInfo(), true)); // Логирование ошибки SQL
            return false;
        }
    }

    public function add($name, $price, $file){
        try {
            $imageId = $this->uploadImage($file);

            $q = "insert into all_toys(name_toys, available, id_photo, price) values('$name', 1, '$imageId', '$price');";
            $smtp = $this->db->prepare($q);
            $smtp->execute();
        } catch (Exception $e) {
            echo 'Ошибка: ' . $e->getMessage();
        }
    }

    public function edit($id, $name, $price, $file){
        $q = "select * from all_toys where id = $id";
        $smtp = $this->db->prepare($q);
        $smtp->execute();
        $r = $smtp->fetchAll()[0];
        $imageId = $r['id_photo'];
        $imageIdOld = $imageId;
        $imageFilenameOld = $r['filename'];
        if(!empty($file)){
            $imageId = $this->uploadImage($file);
        }

        $q = "update all_toys set name_toys = '$name', price = '$price', id_photo = $imageId where id = $id";
        $smtp = $this->db->prepare($q);
        $smtp->execute();

        if(!empty($file)){
            $q = "delete from images where id = $imageIdOld";
            $smtp = $this->db->prepare($q);
            $smtp->execute();
            unlink(realpath(__DIR__ . '/../../images/'.$imageFilenameOld));
        }


    }

    public function remove($id){
        $q = "select * from all_toys where id = $id";
        $smtp = $this->db->prepare($q);
        $smtp->execute();
        $r = $smtp->fetchAll()[0];
        $imageId = $r['id_photo'];

        $q = "delete from all_toys where id = $id;";
        $smtp = $this->db->prepare($q);
        $smtp->execute();

        $q = "select * from images where id = $imageId";
        $smtp = $this->db->prepare($q);
        $smtp->execute();
        $r = $smtp->fetchAll()[0];
        $imageFilename = $r['filename'];

        unlink(__DIR__ . '/../../images/'.$imageFilename);
        $q = "delete from images where id = $imageId;";
        $smtp = $this->db->prepare($q);
        $smtp->execute();
    }

    private function uploadImage($file){
        $uploader = new FileUploader(__DIR__ . '/../../images');
        $uploadedFileName = $uploader->upload($file);
        $q = "insert into images(`filename`) values('$uploadedFileName');";
        $smtp = $this->db->prepare($q);
        $smtp->execute();

        $q = "select id from images where filename = '$uploadedFileName';";
        $smtp = $this->db->prepare($q);
        $smtp->execute();
        return $smtp->fetchAll()[0]['id'];
    }
}

?>