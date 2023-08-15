<?php 
namespace App\Services\OrderServices;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Services\BaseService;
use App\Services\Common\SqlCommon;
class OrderService extends BaseService implements IOrderService {
	
    protected $tableName = 'Orders';
    
    /**
	 * @return mixed
	 */
	public function GetAll() {
		$sql = "
			SELECT o.*, u.Username FROM $this->tableName o
			LEFT JOIN Users u ON o.UserId = u.Id
			ORDER BY CreatedAt DESC
		";
		$data = $this->context->fetch($sql);
		$orders = [];
		foreach ($data as $item) {
			$order = new Order($item);
			array_push($orders, $order);
		}
		return $orders;
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
			SELECT o.*, u.Username FROM $this->tableName o
            LEFT JOIN Users u ON o.UserId = u.Id
            ORDER BY CreatedAt DESC
            LIMIT $offset, $pageSize
		";
        $data = $this->context->fetch($sql);
        $orders = [];
        foreach ($data as $item) {
            $order = new Order($item);
            array_push($orders, $order);
        }
        return $orders;
	}
	
	/**
	 *
	 * @param mixed $id
	 * @return mixed
	 */
	public function GetById($id) {
        $sql = "
            SELECT o.*, u.Username FROM $this->tableName o
            LEFT JOIN Users u ON o.UserId = u.Id
            WHERE o.Id = $id
        ";
        $data = $this->context->fetch_one($sql);
        $order = new Order($data);
        return $order;
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
        $data['UpdatedAt'] = date('Y-m-d H:i:s');
        $data['UpdatedBy'] = $data['UpdatedBy'] ?? 'System';
        $sql = SqlCommon::UPDATE($this->tableName, $data, $id);
        return $this->context->query($sql) ? true : false;
	}
	
	/**
	 *
	 * @param mixed $id
	 * @return mixed
	 */
	public function Delete($id) {
        $sql = SqlCommon::DELETE($this->tableName, $id);
        return $this->context->query($sql) ? true : false;
	}
	/**
	 * @param mixed $id
	 * @param mixed $pageIndex
	 * @param mixed $pageSize
	 * @return mixed
	 */
	public function GetByUserId($id, $pageIndex, $pageSize) {
		$offset = ($pageIndex - 1) * $pageSize;
		$sql = "
			SELECT o.*, u.Username FROM $this->tableName o
			LEFT JOIN Users u ON o.UserId = u.Id
			WHERE o.UserId = '$id'
			ORDER BY CreatedAt DESC
			LIMIT $offset, $pageSize
		";
		$data = $this->context->fetch($sql);
		$orders = [];
		foreach ($data as $item) {
			$order = new Order($item);
			array_push($orders, $order);
		}
		return $orders;

	}
}