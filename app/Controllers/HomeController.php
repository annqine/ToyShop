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
        // Создаем модель и получаем данные
        $toyModel = new Toy();
        $toys = $toyModel->getAllToys();
        // Отображаем HTML для обычного запроса
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
        // Создаем модель и получаем данные
        $toyModel = new Toy();
        $toys = $toyModel->getAllToys();
        $pagination = new Pagination();

        $response = $pagination->paginate("SELECT t.*, CONCAT('/images/', i.filename) AS photo_url FROM all_toys t LEFT JOIN images i ON t.id_photo = i.id", "all_toys", $_GET['page'], $_GET['rows'], $_GET['sidx'], $_GET['sord']);

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function toysEdit()
    {
        $toys = new Toy();
        $name = Request::post('name_toys');
        $id = Request::post('toysTable_id');
        $price = Request::post('price');

        if (Request::post('oper') == 'add' && !empty($_FILES)) {
            $toys->add($name, $price, $_FILES['file']);
        } elseif (Request::post('oper') == 'edit' && $id) {

            $toys->edit($id, $name, $price, $_FILES['file']);
        } elseif (Request::post('oper') == 'del' && Request::post('id')) {
            $toys->remove(Request::post('id'));
        }
    }

    /*public function addToy()
    {
        if ($_POST) {
            $toyModel = new Toy();
            $data = [
                'name_toys' => $_POST['name_toys'],
                'price' => $_POST['price'],
                'id_photo' => $_POST['id_photo'],
            ];
            $toyModel->addToy($data);
            echo json_encode(['status' => 'success']);
        }
    }

    public function editToy()
    {
        if ($_POST) {
            $toyModel = new Toy();
            $data = [
                'id' => $_POST['id'],
                'name_toys' => $_POST['name_toys'],
                'price' => $_POST['price'],
                'id_photo' => $_POST['id_photo'],
            ];
            $toyModel->editToy($data);
            echo json_encode(['status' => 'success']);
        }
    }

    public function deleteToy()
    {
        if ($_POST) {
            $toyModel = new Toy();
            $toyModel->deleteToy($_POST['id']);
            echo json_encode(['status' => 'success']);
        }
    }*/
}
?>