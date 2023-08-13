<?php

namespace App\Controllers;

use App\Core\Config;
use App\Core\Controller;
use App\Services\Common\Helper;
use App\Services\Common\Pagination;
use App\Services\UserServices\UserService;

class UserController extends Controller
{
    private $userService = null;
    public function __construct()
    {
        $this->userService = new UserService();
    }
    public function Index($page = null)
    {
        $pageConfig = Config::PageConfig();
        $pageIndex = $page ?? 0;
        $totalRecords   = count($this->userService->GetAll());
        $pagConfig = [
            'baseURL' => '/user/page',
            'totalRows' => $totalRecords,
            'perPage' => $pageConfig['PageSize'],
        ];
        $pagination = new Pagination($pagConfig);

        $users = $this->userService->GetWithPaginate($pageIndex, $pageConfig['PageSize']);
        // Load the view and pass data
        $this->view('User.Index', [
            'users' => $users,
            'pagination' => $pagination,
            'title' => 'Danh sách người dùng'
        ]);
    }
    public function Detail($id, $slug)
    {
        // Retrieve all users from the database
        $user = $this->userService->GetById($id);
        // Load the view and pass data
        $this->view('User.Detail', [
            'id' => $id,
            'user' => $user,
            'slug' => $slug,
            'title' => 'User Detail'
        ]);
    }

    public function Create()
    {
        // Handle form submission to create a new user
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $user = [
                'Username' => $_POST['Username'],
                'Email' => $_POST['Email'],
                'FullName' => $_POST['FullName'],
                'Password' => Helper::HashSha128($_POST['Password']),
            ];
            $this->userService->Add($user);
        }

        // Load the view for creating a new user
        $this->view('User.Create', ['title' => 'Create User']);
    }

    public function Edit($id)
    {
        // Retrieve the user from the database by ID
        $user = $this->userService->GetById($id);

        if (!$user) {
            // Handle user not found
            echo 'User not found';
            return;
        }

        // Handle form submission to update the user
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and process form data
            // Example: $user->update($_POST);
        }

        // Load the view for editing the user
        $this->view('User/Edit', ['user' => $user]);
    }

    public function Delete($id)
    {
        // Retrieve the user from the database by ID
        $user = $this->userService->GetById($id);

        if (!$user) {
            // Handle user not found
            echo 'User not found';
            return;
        }

        // Handle user deletion
        // Example: $user->delete();

        // Redirect to the user list after deletion
        header('Location: /user');
    }
}
