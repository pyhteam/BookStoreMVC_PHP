<?php 
namespace App\Services\RolePermissionServices;
interface IRolePermissionSerivce {
     public function GetPermissionByRole($roleName);

     public function AddPermissionToRole($permissionId, $roleId);
     public function RemovePermissionFromRole($permissionId, $roleId);
}