<?php

namespace App\Controllers;

use App\Core\Controller;

class DashboardController extends AdminController
{
    public function __construct()
    {
        // base controller
        parent::__construct();
    }
    public function Index()
    {
        $this->view('Dashboard.Index', ['title' => 'Home']);
    }
}
