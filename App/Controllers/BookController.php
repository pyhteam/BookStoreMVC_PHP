<?php

namespace App\Controllers;

use App\Core\Config;
use App\Core\Controller;
use App\Services\BookCategoryServices\BookCategoryService;
use App\Services\BookServices\BookService;
use App\Services\Common\Helper;
use App\Services\Common\Pagination;
use App\Services\Common\Request;
use App\Services\Common\Response;

class BookController extends AdminController
{
    private  $bookService;
    private $bootCategoryService;
    public function __construct()
    {
        $this->bookService = new  BookService();
        $this->bootCategoryService = new  BookCategoryService();
        // base controller  
        parent::__construct();
    }

    public function Index($page = null)
    {
        $pageConfig = Config::PageConfig();
        $pageIndex = $page ?? 1;
        $totalRecords   = count($this->bookService->GetAll());
        $pagConfig = [
            'baseURL' => '/book/page',
            'totalRows' => $totalRecords,
            'perPage' => $pageConfig['PageSize'],
        ];
        $pagination = new Pagination($pagConfig);
        $books = $this->bookService->GetWithPaginate($pageIndex, $pageConfig['PageSize']);
        // Load the view and pass data
        $this->view('Book.Index', [
            'books' => $books,
            'pagination' => $pagination,
            'title' => 'Danh sách Danh mục sách'
        ]);
    }
    public function Create()
    {
        $bookCategories = $this->bootCategoryService->GetAll();
        // Handle form submission to create a new user
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $bookAdd = [
                'Title' => Request::post('Title'),
                'Author' =>Request::post('Author'),
                'CategoryId' => Request::post('CategoryId'),
                'Price' => Request::post('Price'),
                'Quantity' => Request::post('Quantity'),
                'Description' => Request::post('Description'),
                'Image' => Request::post('Image'),

                'Slug' => Helper::Slugify(Request::post('Title'))
            ];
            $this->bookService->Add($bookAdd);
            $this->redirect('/book');
        }

        // Load the view for creating a new user
        $this->view('Book.Create', ['title' => 'Tạo mới sách', 'bookCategories' => $bookCategories]);
    }

    public function Edit($id)
    {
        // Retrieve the user from the database by ID
        $book = $this->bookService->GetById($id);
        $bookCategories = $this->bootCategoryService->GetAll();

        if (!$book) {
            // Handle user not found
            $this->redirect('/404');
            return;
        }

        // Handle form submission to update the user
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bookSave = [
                'Title' => $_POST['Title'],
                'Author' => $_POST['Author'],
                'CategoryId' => $_POST['CategoryId'],
                'Price' => $_POST['Price'],
                'Quantity' => $_POST['Quantity'],
                'Description' => $_POST['Description'],
                'Image' => $_POST['Image'],

                'Slug' => Helper::Slugify($_POST['Title'])
            ];

            $this->bookService->Update($bookSave, $id);
            $this->redirect('/book');
        }

        // Load the view for editing the user
        $this->view('Book.Edit', ['book' => $book, 'title' => 'Sửa thông tin sách', 'bookCategories' => $bookCategories]);
    }

    public function Delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $book = $this->bookService->GetById($id);
            if (!$book) {
                $this->redirect('/404');
                return;
            }
            $result = $this->bookService->Delete($id);
            if (!$result) {

                Response::badRequest([], 'Xóa thất bại!', 400);
                return;
            }
            Response::success([], 'Xóa thành công!', 200);
        }
    }
}
