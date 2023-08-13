<?php 
namespace App\Services\UserServices;

use App\Services\Interfaces\IBaseInterface;

interface IUserService extends IBaseInterface
{
    public function GetByUsername($username);
    public function GetByEmail($email);
}