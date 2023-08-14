<?php 
namespace App\Controllers;
use App\Core\Config;
use App\Core\Controller;
use App\Services\Common\Pagination;
use App\Services\Common\Request;
use App\Services\Common\Response;
use App\Services\OrderDetailServices\OrderDetailService;
use App\Services\OrderServices\OrderService;
class OrderController extends Controller {
    private  $orderService;
    private $orderDetailService;
    public function __construct()
    {
        $this->orderService = new  OrderService();
        $this ->orderDetailService = new OrderDetailService();
    }

    public function Index($page = null)
    {
        $pageConfig = Config::PageConfig();
        $pageIndex = $page ?? 1;
        $totalRecords   = count($this->orderService->GetAll());
        $pagConfig = [
            'baseURL' => '/order/page',
            'totalRows' => $totalRecords,
            'perPage' => $pageConfig['PageSize'],
        ];
        $pagination = new Pagination($pagConfig);
        $orders = $this->orderService->GetWithPaginate($pageIndex, $pageConfig['PageSize']);
        // Load the view and pass data
        $this->view('Order.Index', [
            'orders' => $orders,
            'pagination' => $pagination,
            'title' => 'Danh sách Order'
        ]);
    }
    public function Detail($id, $page = 1)
    {
        $order = $this->orderService->GetById($id);

        $pageConfig = Config::PageConfig();
        $pageIndex = $page ?? 1;
        $totalRecords   = count($this->orderService->GetAll());
        $pagConfig = [
            'baseURL' => '/order/detail/' . $id . '/page',
            'totalRows' => $totalRecords,
            'perPage' => $pageConfig['PageSize'],
        ];
        $pagination = new Pagination($pagConfig);
        $order->OrderDetails = $this->orderDetailService->GetByOrderId($id, $pageIndex, $pageConfig['PageSize']);
        // Load the view and pass data
        $this->view('Order.Detail', [
            'id' => $id,
            'order' => $order,
            'pagination' => $pagination,
            'title' => 'Order Detail'
        ]);
    }
    public function UpdateStatus($id)
    {
       if(Request::method('POST')){
            $order = $this->orderService->GetById($id);
            $order = [
                'Status' => 'Approved'
            ];
            $result = $this->orderService->Update($order, $id);
            return  $result ? Response::success('Cập nhật thành công') : Response::badRequest('Cập nhật thất bại');
       }
    }
    public function Delete($id)
    {
        if(Request::method('DELETE')){
            $result = $this->orderService->Delete($id);
            return  $result ? Response::success('Xóa thành công') : Response::badRequest('Xóa thất bại');
        }
    }
}