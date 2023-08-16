<?php

namespace App\Controllers;

use App\Core\Config;
use App\Core\Controller;
use App\Services\BookServices\BookService;
use App\Services\Common\Helper;
use App\Services\Common\Pagination;
use App\Services\Common\Request;
use App\Services\Common\Response;
use App\Services\Common\Session;
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
    public function Search($key)
    {   
        $key = urldecode($key);
        $books = $this->bookService->GetByKey($key);
        $this->view('Home.Search', [
            'title' => 'Search by - ' . $key,
            'layout' => $this->layout,
            'books' => $books,
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
            $codeOrder = Helper::RandomString(6);
            $oder = [
                'Code' => $codeOrder,
                'UserId' => Session::get('user')->Id,
                'TotalPrice' => Request::post('TotalPrice'),
                'Status' => "Pending",
                'ShipName' => Request::post('ShipName'),
                'ShipPhone' => Request::post('ShipPhone'),
                'ShipAddress' => Request::post('ShipAddress'),
            ];
            $result = $this->orderService->Add($oder);
            if(!$result) return Response::badRequest('Đặt hàng thất bại');

            // get order id
            $order = $this->orderService->GetByCode($codeOrder);
            if(!$order) return Response::notFound('Invalid order');
            $orderDetails = Request::post('OrderDetails');
            $orderDetailsSave = [];
            foreach($orderDetails as $orderDetail){
                array_push($orderDetailsSave,[
                    'OrderId' => $order->Id,
                    'BookId' => $orderDetail['BookId'],
                    'Quantity' => $orderDetail['Quantity']
                ]);
            }
            foreach($orderDetailsSave as $orderDetail){
                $result = $this->orderDetailService->Add($orderDetail);
                if(!$result) return Response::badRequest('Chi tiết đặt hàng thất bại');
            }
            return Response::success('Đặt hàng thành công');
        }
    }
    public function Cancelled($id){
        if(Request::method('POST')){
            $order = $this->orderService->GetById($id);
            $order = [
                'Status' => !Request::get('Status') ? 'Cancelled' : Request::get('Status')
            ];
            $result = $this->orderService->Update($order, $id);
            return  $result ? Response::success('Cập nhật thành công') : Response::badRequest('Cập nhật thất bại');
        }
    }
}
