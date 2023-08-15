<?php

namespace App\Controllers;

use App\Core\Config;
use App\Core\Controller;
use App\Services\BookServices\BookService;
use App\Services\Common\Pagination;

class HomeController extends Controller
{

    private $layout = '_ClientLayout';
    private  $bookService;
    public function __construct()
    {
        $this->bookService = new BookService();
    }
    public function Index($page = 1)
    {

        $pageConfig = Config::PageConfig();
        $pageIndex = $page ?? 1;
        $totalRecords   = count($this->bookService->GetAll());
        $pagConfig = [
            'baseURL' => '/home/page',
            'totalRows' => $totalRecords,
            'perPage' => $pageConfig['PageSize'],
        ];
        $pagination = new Pagination($pagConfig);

        $booksLatest = $this->bookService->GetBookLastes($pageIndex, $pageConfig['PageSize']);
        $bookBestSeller = $this->bookService->GetBestSeller(4);
        $this->view('Home.Index', [
            'title' => 'Home',
            'layout' => $this->layout,
            'booksLatest' => $booksLatest,
            'bookBestSeller' => $bookBestSeller,
            'pagination' => $pagination,
        ]);
    }
    public function Detail($slug,$id)
    {
        $book = $this->bookService->GetById($id);
        $booksRelated = $this->bookService->GetByCategory($book->CategoryId, 4);
        $this->view('Home.Detail', [
            'title' => 'Home',
            'layout' => $this->layout,
            'book' => $book,
            'booksRelated' => $booksRelated,
        ]);
    }
}
