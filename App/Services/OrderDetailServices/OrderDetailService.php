<?php 
namespace App\Services\OrderDetailServices;
use App\Models\OrderDetail;
use App\Services\BaseService;
use App\Services\Common\SqlCommon;

class OrderDetailService extends BaseService implements IOrderDetailService {
    
    protected $tableName = 'OrderDetails';
	/**
	 * @param mixed $orderId
	 * @return mixed
	 */
	public function GetByOrderId($orderId, $pageIndex, $pageSize) {
        $offset = ($pageIndex - 1) * $pageSize;
        $sql = "
            SELECT od.*, b.Title AS BookName, b.Image AS BookImage, b.Price AS BookPrice FROM $this->tableName od
            LEFT JOIN Book b ON od.BookId = b.Id
            WHERE od.OrderId = '$orderId'
            ORDER BY CreatedAt DESC
            LIMIT $offset, $pageSize
        ";
        $data = $this->context->fetch($sql);
        $orderDetails = [];
        foreach ($data as $item) {
            $orderDetail = new OrderDetail($item);
            array_push($orderDetails, $orderDetail);
        }
        return $orderDetails;
	}
	
	/**
	 * @return mixed
	 */
	public function GetAll() {
		$sql = "
			SELECT od.*, b.Title AS BookName, b.Image AS BookImage, b.Price AS BookPrice FROM $this->tableName od
			LEFT JOIN Book b ON od.BookId = b.Id
			ORDER BY CreatedAt DESC
		";
		$data = $this->context->fetch($sql);
		$orderDetails = [];
		foreach ($data as $item) {
			$orderDetail = new OrderDetail($item);
			array_push($orderDetails, $orderDetail);
		}
		return $orderDetails;
	}
	
	/**
	 *
	 * @param mixed $pageIndex
	 * @param mixed $pageSize
	 * @return mixed
	 */
	public function GetWithPaginate($pageIndex, $pageSize) {
        $offset = ($pageIndex - 1) * $pageSize;
        $sql = "
            SELECT od.*, b.Title AS BookName, b.Image AS BookImage, b.Price AS BookPrice FROM $this->tableName od
            LEFT JOIN Book b ON od.BookId = b.Id
            ORDER BY CreatedAt DESC
            LIMIT $offset, $pageSize
        ";
        $data = $this->context->fetch($sql);
        $orderDetails = [];
        foreach ($data as $item) {
            $orderDetail = new OrderDetail($item);
            array_push($orderDetails, $orderDetail);
        }
        return $orderDetails;
	}
	
	/**
	 *
	 * @param mixed $id
	 * @return mixed
	 */
	public function GetById($id) {
        $sql = SqlCommon::SELECT_CONDITION($this->tableName, " WHERE Id = '$id'");
        $data = $this->context->fetch_one($sql);
        $orderDetail = new OrderDetail($data);
        return $orderDetail;
	}
	
	/**
	 *
	 * @param mixed $data
	 * @return mixed
	 */
	public function Add($data) {
        $data['CreatedAt'] = date('Y-m-d H:i:s');
        $data['CreatedBy'] = $data['CreatedBy'] ?? 'System';
        $data['IsActive'] = $data['IsActive'] ?? 1;
        $sql = SqlCommon::INSERT($this->tableName, $data);
        return $this->context->query($sql) ? true : false; 
	}
	
	/**
	 *
	 * @param mixed $data
	 * @param mixed $id
	 * @return mixed
	 */
	public function Update($data, $id) {
        

	}
	
	/**
	 *
	 * @param mixed $id
	 * @return mixed
	 */
	public function Delete($id) {
        $sql = SqlCommon::DELETE($this->tableName, " WHERE Id = '$id'");
        return $this->context->query($sql) ? true : false;
	}
}