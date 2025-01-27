<?php
use Core\Request;
use Core\Pagination;
require_once __DIR__ . '/../Models/Toy.php';
require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Core/Pagination.php';
//require_once __DIR__ . '/../Core/FileUploader.php';

class HomeController extends Controller
{
    public function index()
    {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $sidx = isset($_GET['sidx']) ? $_GET['sidx'] : 'id';
        $sord = isset($_GET['sord']) ? $_GET['sord'] : 'asc';
        $category = isset($_GET['category']) ? intval($_GET['category']) : null;
        $query = isset($_GET['query']) ? $_GET['query'] : null;

        $query = Request::get('query');
        $category = Request::get('category');

        $model = new Toy();
        $response = $model->getAllToys($category, $query, $page, $rows, $sidx, $sord);
        $this->view('home', [
            'data' => $response['data'],
            'page' => $page,
            'total' => $response['total'],
            'records' => count($response['data']),
            'rows' => $rows,
            'sidx' => $sidx,
            'sord' => $sord,
            'category' => $category,
            'query' => $query
        ]);
    }
    
}
?>