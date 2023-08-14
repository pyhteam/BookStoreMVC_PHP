<?php 
namespace App\Controllers;
use App\Core\Controller;
use App\Services\Common\Session;

class AdminController extends Controller {
    public function __construct() {
        if(!Session::Authorize()) {
            header('Location: /auth/login');
            exit();
        }
    }
}