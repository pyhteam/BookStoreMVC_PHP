<?php 
namespace App\Services\BookServices;
use App\Services\Interfaces\IBaseInterface;
interface IBookService extends IBaseInterface {
    public function GetByCategory($CategoryId,$pageIndex,$pageSize);

    // for client 
    //get book lastes
    public function GetBookLastes($pageIndex,$pageSize);
    public function GetBestSeller($limit);


}