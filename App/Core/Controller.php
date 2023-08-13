<?php

namespace App\Core;

class Controller
{
    private $layout = '_LayoutAdmin';
    protected function view($viewName, $data = [])
    {   
        $layoutName = $data['layout'] ?? $this->layout;
        $viewName = str_replace('.', '/', $viewName);
        // Extract data for use in the view
        extract($data);
        // Load the view file
        require_once "../App/Views/Shared/$layoutName.php";
    }
    protected function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
