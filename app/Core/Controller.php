<?php
class Controller
{
    public function view($viewName, $data = [], $return = false)
    {
        ob_start();
        extract($data); // Вытягиваем данные в локальные переменные
        include __DIR__ . "/../Views/{$viewName}.php";
        $content = ob_get_clean();

        if ($return) {
            return $content;
        } else {
            echo $content;
        }
    }
}
?>