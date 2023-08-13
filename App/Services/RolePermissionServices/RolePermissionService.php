<?php 
namespace App\Services\RolePermissionServices;
use App\Core\Database;
class RolePermissionService implements IRolePermissionSerivce
{
    protected $tableName = 'RolesPermissions';
    protected $context;
    public function __construct()
    {
        $this->context = Database::getInstance();
    }
	/**
	 * @param mixed $roleName
	 * @return mixed
	 */
	public function GetPermissionByRole($roleName) 
    {
        $sql = "SELECT * FROM $this->tableName WHERE RoleId = (SELECT Id FROM Roles WHERE Name = '$roleName')";
        $result = $this->context->fetch($sql);
        return $result;
	}
	
	/**
	 *
	 * @param mixed $permissionId
	 * @param mixed $roleId
	 * @return mixed
	 */
	public function AddPermissionToRole($permissionId, $roleId) {
        $sql = "INSERT INTO $this->tableName (PermissionId, RoleId) VALUES ($permissionId, $roleId)";
        $result = $this->context->query($sql);
        return $result;
	}
	
	/**
	 *
	 * @param mixed $permissionId
	 * @param mixed $roleId
	 * @return mixed
	 */
	public function RemovePermissionFromRole($permissionId, $roleId) {
        $sql = "DELETE FROM $this->tableName WHERE PermissionId = $permissionId AND RoleId = $roleId";
        $result = $this->context->query($sql);
        return $result;
	}
}