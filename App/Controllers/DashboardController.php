<?php

namespace App\Controllers;

use App\Core\Controller;

class DashboardController extends Controller
{
    public function Index()
    {
        $this->view('Dashboard.Index', ['title' => 'Home']);
    }
}
