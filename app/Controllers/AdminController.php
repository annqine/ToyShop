<?php
use Core\Request;
use Core\Pagination;
require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/Toy.php';
require_once __DIR__ . '/../Core/Pagination.php';
require_once __DIR__ . '/../Core/FileUploader.php';
class AdminController extends Controller{
    
    public function toys()
    {
        $pagination = new Pagination();

        $page = $_GET['page'] ?? 1;
        $rows = $_GET['rows'] ?? 10;
        $sidx = $_GET['sidx'] ?? 'id';
        $sord = $_GET['sord'] ?? 'asc';
        $category = $_GET['category'] ?? null; // Новое поле для фильтрации по категории

        $query = "SELECT t.*, CONCAT('/images/', i.filename) AS photo_url 
                  FROM all_toys t
                  LEFT JOIN images i ON t.id_photo = i.id";

        if ($category !== null) {
            $query .= " WHERE t.category = :category";
        }

        $response = $pagination->paginate($query, "all_toys", $page, $rows, $sidx, $sord, $category);

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function admin()
    {
        $toyModel = new Toy();
        $toys = $toyModel->getAllToys();
        $this->view('admin', ['toys' => $toys]);
    }

    public function toysEdit()
    {
        $toyModel = new Toy();
        $name = Request::post('name_toys');
        $id = Request::post('toysTable_id');
        $price = Request::post('price');
        $category = Request::post('category'); // Новый параметр для категории

        if (Request::post('oper') == 'add' && !empty($_FILES)) {
            $toyModel->add($name, $price, $category, $_FILES['file']);
        } elseif (Request::post('oper') == 'edit' && $id) {
            $toyModel->edit($id, $name, $price, $category, $_FILES['file']);
        } elseif (Request::post('oper') == 'del' && Request::post('id')) {
            $toyModel->remove(Request::post('id'));
        }
    }
}
?>