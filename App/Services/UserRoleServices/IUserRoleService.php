<?php 
namespace App\Services\UserRoleServices;

interface IUserRoleService
{    
    public function GetRoleByUsername($username);
    public function GetUsernameByRole($roleName);
    public function AddRoleToUser($userId, $roleId);
    public function RemoveRoleFromUser($userId, $roleId);
}