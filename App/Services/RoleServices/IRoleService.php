<?php 
namespace App\Services\RoleServices;
use App\Services\Interfaces\IBaseInterface;

interface IRoleService extends IBaseInterface
{
    public function GetByName($username);
}