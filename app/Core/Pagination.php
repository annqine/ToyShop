<?php


namespace Core;

use Model;
use PDO;

require_once __DIR__ . '/../Core/Request.php';
class Pagination extends Model
{
    public function dd($value)
    {
        echo '<pre>';
        print_r($value);
        echo '</pre>';
        die();
    }

    public function paginate($baseQuery, $table, $page, $rows, $sidx, $sord)
    {
        $SEARCH_OPERATIONS = [
            'eq' => '=',
            'ne' => '<>',
            'lt' => '<',
            'le' => '<=',
            'gt' => '>',
            'ge' => '>='
        ];

        // Отримання параметрів пагінації
        $page = isset($page) ? intval($page) : 1; // Поточна сторінка
        $rowsPerPage = isset($rows) ? intval($rows) : 10; // Кількість рядків на сторінці

        // Розрахунок початкового та кінцевого рядка
        $startRow = ($page - 1) * $rowsPerPage;
        $endRow = $startRow + $rowsPerPage;

        // Запит для отримання даних з пагінацією
        $q = "{$baseQuery}";

        $searchField = Request::get("searchField");
        $searchString = Request::get("searchString");
        $searchOperation = Request::get("searchOper");

        if (Request::get('_search')) {
            if (array_key_exists($searchOperation, $SEARCH_OPERATIONS)) {
                //$q .= " WHERE {$searchField} {$SEARCH_OPERATIONS[$searchOperation]} '{$searchString}' ";
                $q .= " WHERE t.{$searchField} {$SEARCH_OPERATIONS[$searchOperation]} '{$searchString}' ";
            } else
                switch ($searchOperation) {
                    case 'bw':
                        $q .= " WHERE t.{$searchField} LIKE '{$searchString}%' ";
                        break;
                    case 'nw':
                        $q .= " WHERE t.{$searchField} NOT LIKE '{$searchString}%' ";
                        break;
                    case 'ew':
                        $q .= " WHERE t.{$searchField} LIKE '%{$searchString}' ";
                        break;
                    case 'en':
                        $q .= " WHERE t.{$searchField} NOT LIKE '%{$searchString}' ";
                        break;
                    case 'nc':
                        $q .= " WHERE t.{$searchField} NOT LIKE '%{$searchString}%' ";
                        break;
                    default:
                        $q .= " WHERE t.{$searchField} LIKE '%{$searchString}%' ";
                        break;
                }
        }
        if (!empty($sidx)) {
            $q .= " ORDER BY t.`{$sidx}` {$sord}";
        }

        $totalRecords = 0;
        $stmt = $this->db->prepare($q);
        if ($stmt->execute()) {
            $totalRecords = count($stmt->fetchAll(PDO::FETCH_ASSOC));
        } else {
            error_log("SQL Error: " . print_r($stmt->errorInfo(), true)); // Логирование ошибки SQL
        }

        $q .= " limit {$startRow}, {$endRow}";
        $stmt = $this->db->prepare($q);

        $result = null;
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            error_log("SQL Error: " . print_r($stmt->errorInfo(), true)); // Логирование ошибки SQL
        }

        $data = array_values($result);
        // Створення JSON-відповіді
        return array(
            "page" => $page,
            "total" => ceil($totalRecords / $rows),
            "records" => $totalRecords,
            "data" => $data
        );
    }
    
}