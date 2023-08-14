<?php

namespace App\Controllers;

use App\Core\Controller;

class ErrorController extends AdminController
{
    public function __construct()
    {
        // base controller
        parent::__construct();
    }
    public function PageNotFound()
    {
        $this->view('Error.404', ['title' => 'Page Not Found']);
    }
}
