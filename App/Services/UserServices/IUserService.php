<?php 
namespace App\Services\UserServices;

use App\Services\Interfaces\IBaseInterface;

interface IUserService extends IBaseInterface
{
    public function GetByUsername($username);
    public function GetByEmail($email);
    public function Login($email, $password);
    public function Register($user);


}