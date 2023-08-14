<?php 
namespace App\Models;
use App\Models\Base\BaseModel;
class OrderDetail  extends BaseModel {

    public $OrderId;
    public $BookId;
    public $Quantity;

    // For View
    public $BookName;
    public $BookPrice;
    public $BookImage;


    public function __construct($orderDetail)
    {
        $this->OrderId = $orderDetail['OrderId'];
        $this->BookId = $orderDetail['BookId'];
        $this->Quantity = $orderDetail['Quantity'];
        // For View
        $this->BookName = $orderDetail['BookName'] ?? '';
        $this->BookPrice = $orderDetail['BookPrice'] ?? '';
        $this->BookImage = $orderDetail['BookImage'] ?? '';

        parent::__construct($orderDetail);
    }
}