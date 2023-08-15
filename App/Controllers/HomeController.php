<?php

namespace App\Controllers;

use App\Core\Config;
use App\Core\Controller;
use App\Services\BookServices\BookService;
use App\Services\Common\Pagination;
use App\Services\Common\Request;
use App\Services\OrderDetailServices\OrderDetailService;
use App\Services\OrderServices\OrderService;

class HomeController extends Controller
{

    private $layout = '_ClientLayout';
    private  $bookService;
    private  $orderService;
    private  $orderDetailService;
    public function __construct()
    {
        $this->bookService = new BookService();
        $this->orderService = new OrderService();
        $this->orderDetailService = new OrderDetailService();
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

    // [GET]
    public function CheckOut(){

        $this->view('Home.CheckOut', [
            'title' => 'Home',
            'layout' => $this->layout,
        ]);
    }
    // [POST]
    public function Order(){
        if(Request::method('POST')){
            $data = [
                'OrderId' => uniqid(),
                'BookId' => Request::post('BookId'),
                'Quantity' => Request::post('Quantity'),
            ]
        }
    }
}
