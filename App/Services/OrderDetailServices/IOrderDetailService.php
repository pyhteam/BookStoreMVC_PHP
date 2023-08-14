<?php

namespace App\Services\OrderDetailServices;

use App\Services\Interfaces\IBaseInterface;

interface IOrderDetailService extends IBaseInterface
{
    public function GetByOrderId($orderId, $pageIndex, $pageSize);
}
