<?php 
namespace App\Services\PermissionServices;
use App\Services\Interfaces\IBaseInterface;

interface IPermissionService extends IBaseInterface
{
    public function GetByKey($key);
}