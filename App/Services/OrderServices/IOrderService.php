<?php 
namespace App\Services\OrderServices;
use App\Services\Interfaces\IBaseInterface;
interface IOrderService extends IBaseInterface {

    public function GetByUserId($id,$pageIndex,$pageSize);
    public function GetByCode($code);
}