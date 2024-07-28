<?php

use Core\Pagination;
use Core\Request;

require_once __DIR__ . '/../Models/Toy.php';
require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Core/Pagination.php';
require_once __DIR__ . '/../Core/FileUploader.php';

class HomeController extends Controller
{
    public function index()
    {
        $toyModel = new Toy();
        $toys = $toyModel->getAllToys();
        $this->view('home', ['toys' => $toys]);
    }

    public function admin()
    {
        $toyModel = new Toy();
        $toys = $toyModel->getAllToys();
        $this->view('admin', ['toys' => $toys]);
    }

    public function dd($value)
    {
        echo '<pre>';
        print_r($value);
        echo '</pre>';
        die();
    }

    public function toys()
    {
        $toyModel = new Toy();
        $pagination = new Pagination();

        // Получаем параметры запроса для пагинации
        $page = $_GET['page'] ?? 1;
        $rows = $_GET['rows'] ?? 10;
        $sidx = $_GET['sidx'] ?? 'id';
        $sord = $_GET['sord'] ?? 'asc';
        $category = $_GET['category'] ?? null; // Новое поле для фильтрации по категории

        $query = "SELECT t.*, CONCAT('/images/', i.filename) AS photo_url 
                  FROM all_toys t
                  LEFT JOIN images i ON t.id_photo = i.id";

        // Добавляем условие фильтрации по категории, если оно задано
        if ($category !== null) {
            $query .= " WHERE t.category = :category";
        }

        $response = $pagination->paginate($query, "all_toys", $page, $rows, $sidx, $sord, $category);

        header('Content-Type: application/json');
        echo json_encode($response);
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

    public function search()
    {
        $query = Request::get('query');
        $category = Request::get('category'); // Новый параметр для поиска по категории

        $toyModel = new Toy();
        if ($category !== null) {
            $toys = $toyModel->getAllToys($category);
        } else {
            $toys = $toyModel->searchToys($query);
        }
        $this->view('home', ['toys' => $toys]);
    }
}
?>