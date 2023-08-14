<?php
namespace App\Controllers;
use App\Core\Config;
use App\Core\Controller;
use App\Services\Common\Pagination;
use App\Services\Common\Response;
use App\Services\RoleServices\RoleService;

class RoleController extends Controller
{
    private $roleService = null;
    public function __construct()
    {
        $this->roleService = new RoleService();
    }
    public function Index($page = null)
    {
        $pageConfig = Config::PageConfig();
        $pageIndex = $page ?? 1;
        $totalRecords   = count($this->roleService->GetAll());
        $pagConfig = [
            'baseURL' => '/user/page',
            'totalRows' => $totalRecords,
            'perPage' => $pageConfig['PageSize'],
        ];
        $pagination = new Pagination($pagConfig);

        $roles = $this->roleService->GetWithPaginate($pageIndex, $pageConfig['PageSize']);
        // Load the view and pass data
        $this->view('Role.Index', [
            'roles' => $roles,
            'pagination' => $pagination,
            'title' => 'Danh sách quyền'
        ]);
    }
    public function Detail($id, $slug)
    {
        // Retrieve all users from the database
        $user = $this->roleService->GetById($id);
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

            $role = [
                'Name' => $_POST['Name'],
            ];
            $this->roleService->Add($role);
            $this->redirect('/role');
        }

        // Load the view for creating a new user
        $this->view('Role.Create', ['title' => 'Tạo mới quyền']);
    }

    public function Edit($id)
    {
        // Retrieve the user from the database by ID
        $role = $this->roleService->GetById($id);

        if (!$role) {
            // Handle user not found
            $this->redirect('/404');
            return;
        }

        // Handle form submission to update the user
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $role = [
                'Name' => $_POST['Name'],
            ];

            $this->roleService->Update($role, $id);
            $this->redirect('/role');
        }

        // Load the view for editing the user
        $this->view('Role.Edit', ['role' => $role, 'title' => 'Sửa quyền']);
    }

    public function Delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $role = $this->roleService->GetById($id);
            if (!$role) {
                $this->redirect('/404');
                return;
            }
            $result = $this->roleService->Delete($id);
            if (!$result) {
                
                Response::badRequest([], 'Xóa thất bại!', 400);
                return;
            }
             Response::success([], 'Xóa thành công!', 200);
        }
    }
}
