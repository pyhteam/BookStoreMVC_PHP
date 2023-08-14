<?php 
namespace App\Services\BookServices;
use App\Services\Interfaces\IBaseInterface;
interface IBookService extends IBaseInterface {
    public function GetByCategory($CategoryId,$pageIndex,$pageSize);
}