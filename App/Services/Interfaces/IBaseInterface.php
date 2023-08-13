<?php 
namespace App\Services\Interfaces;

interface IBaseInterface
{
    public function GetAll();
    public function GetWithPaginate($pageIndex, $pageSize);
    public function GetById($id);
    public function Add($data);
    public function Update($data, $id);
    public function Delete($id);
}