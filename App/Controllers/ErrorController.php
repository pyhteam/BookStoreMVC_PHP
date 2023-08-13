<?php

namespace App\Controllers;

use App\Core\Controller;

class ErrorController extends Controller
{
    public function PageNotFound()
    {
        $this->view('Error.404', ['title' => 'Page Not Found']);
    }
}
