<?php

namespace App\Controllers;

use App\Core\Config;
use App\Core\Controller;
use App\Services\Common\Helper;
use App\Services\Common\Pagination;
use App\Services\Common\Response;
use App\Services\RoleServices\RoleService;
use App\Services\UserRoleServices\UserRoleService;
use App\Services\UserServices\UserService;

class UserController extends Controller
{
    private $userService = null;
    private $userRoleService = null;
    private $roleService = null;
    public function __construct()
    {
        $this->userService = new UserService();
        $this->userRoleService = new UserRoleService();
        $this->roleService = new RoleService();
    }
    public function Index($page = null)
    {
        $pageConfig = Config::PageConfig();
        $pageIndex = $page ?? 1;
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
        $roles = $this->roleService->GetAll();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $user = [
                'Username' => $_POST['Username'],
                'Email' => $_POST['Email'],
                'FullName' => $_POST['FullName'],
                'Password' => Helper::HashSha128($_POST['Password']),
            ];
            $this->userService->Add($user);
            // add role to user
            $user = $this->userService->GetByUsername($user['Username']);
            $roleId = $_POST['RoleId'];
            $this->userRoleService->AddRoleToUser($user->Id, $roleId);
            $this->view('User.Create', ['title' => 'Create User', 'message' => 'Tạo mới thành công', 'roles' => (object)$roles]);
        }
        $this->view('User.Create', ['title' => 'Create User', 'roles' => $roles]);
    }

    public function Edit($id)
    {
        // Retrieve the user from the database by ID
        $user = $this->userService->GetById($id);

        if (!$user) {
            // Handle user not found
            $this->redirect('/404');
            return;
        }

        // Handle form submission to update the user
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userSave = [
                'Username' => $_POST['Username'],
                'Email' => $_POST['Email'],
                'FullName' => $_POST['FullName'],
                'Password' => Helper::HashSha128($_POST['Password']),
            ];
            $roleId = $_POST['RoleId'];
            $this->userService->Update($userSave, $id);
            $this->userRoleService->RemoveRoleFromUser($id, $roleId);
            $this->userRoleService->AddRoleToUser($id, $roleId);
            $this->view('User.Edit', ['user' => $user, 'title' => 'Edit User', 'message' => 'Cập nhật thành công!']);

        }

        // Load the view for editing the user
        $this->view('User/Edit', ['user' => $user]);
    }

    public function Delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $user = $this->userService->GetById($id);
            if (!$user) {
                $this->redirect('/404');
                return;
            }
            $result = $this->userService->Delete($id);
            if (!$result) {

                echo Response::badRequest([], 'Xóa thất bại!', 400);
                return;
            }
            // remove role from user
            $roles = $this->userRoleService->GetRoleByUsername($user->Username);
            foreach ($roles as $role) {
                $this->userRoleService->RemoveRoleFromUser($id, $role['Id']);
            }
            echo Response::success([], 'Xóa thành công!', 200);
        }
    }
}
