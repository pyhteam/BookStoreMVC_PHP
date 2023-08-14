<?php

namespace App\Controllers;

use App\Core\Config;
use App\Core\Controller;
use App\Services\BookCategoryServices\BookCategoryService;
use App\Services\Common\Helper;
use App\Services\Common\Pagination;
use App\Services\Common\Response;

class BookCategoryController extends Controller
{

    private  $bookCategoryService;
    public function __construct()
    {
        $this->bookCategoryService = new  BookCategoryService();
    }

    public function Index($page = null)
    {
        $pageConfig = Config::PageConfig();
        $pageIndex = $page ?? 1;
        $totalRecords   = count($this->bookCategoryService->GetAll());
        $pagConfig = [
            'baseURL' => '/user/page',
            'totalRows' => $totalRecords,
            'perPage' => $pageConfig['PageSize'],
        ];
        $pagination = new Pagination($pagConfig);
        $bookCategories = $this->bookCategoryService->GetWithPaginate($pageIndex, $pageConfig['PageSize']);
        // Load the view and pass data
        $this->view('BookCategory.Index', [
            'bookCategories' => $bookCategories,
            'pagination' => $pagination,
            'title' => 'Danh sách Danh mục sách'
        ]);
    }
    public function Detail($id, $slug)
    {
        // Retrieve all users from the database
        $bookCategory = $this->bookCategoryService->GetById($id);
        // Load the view and pass data
        $this->view('BookCategory.Detail', [
            'id' => $id,
            'user' => $bookCategory,
            'title' => 'Book Category Detail'
        ]);
    }

    public function Create()
    {
        // Handle form submission to create a new user
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $bookCategory = [
                'Name' => $_POST['Name'],
                'Slug' => Helper::Slugify($_POST['Name'])
            ];
            $this->bookCategoryService->Add($bookCategory);
            $this->redirect('/book-category');
        }

        // Load the view for creating a new user
        $this->view('BookCategory.Create', ['title' => 'Tạo mới Danh mục sách']);
    }

    public function Edit($id)
    {
        // Retrieve the user from the database by ID
        $bookCategory = $this->bookCategoryService->GetById($id);

        if (!$bookCategory) {
            // Handle user not found
            $this->redirect('/404');
            return;
        }

        // Handle form submission to update the user
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bookCategorySave = [
                'Name' => $_POST['Name'],
                'Slug' => Helper::Slugify($_POST['Name'])
            ];

            $this->bookCategoryService->Update($bookCategorySave, $id);
            $this->redirect('/book-category');
        }

        // Load the view for editing the user
        $this->view('BookCategory.Edit', ['bookCategory' => $bookCategory, 'title' => 'Sửa quyền']);
    }

    public function Delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $bookCategory = $this->bookCategoryService->GetById($id);
            if (!$bookCategory) {
                $this->redirect('/404');
                return;
            }
            $result = $this->bookCategoryService->Delete($id);
            if (!$result) {

                Response::badRequest([], 'Xóa thất bại!', 400);
                return;
            }
            Response::success([], 'Xóa thành công!', 200);
        }
    }
}
