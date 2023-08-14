<?php 
namespace App\Models;

use App\Models\Base\BaseModel;

class Order extends BaseModel {

    public $UserId;
    public $TotalPrice;
    public $Status;
    public $ShipAddress;
    public $ShipName;
    public $ShipPhone;
    // For View
    public $Username;
    public $OrderDetails = []; // List<OrderDetail> OrderDetails

    public function __construct($order)
    {
        $this->UserId = $order['UserId'];
        $this->TotalPrice = $order['TotalPrice'];
        $this->Status = $order['Status'];
        $this->ShipName = $order['ShipName'] ?? '';
        $this->ShipPhone = $order['ShipPhone'] ?? '';
        $this->ShipAddress = $order['ShipAddress'] ?? '';
        // For View
        $this->Username = $order['Username'] ?? '';
        $this->OrderDetails = $order['OrderDetails'] ?? [];
        parent::__construct($order);
    }
}