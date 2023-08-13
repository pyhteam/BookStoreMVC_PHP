<?php 
namespace App\Services\UserRoleServices;
use App\Core\Database;
class UserRoleService implements IUserRoleService
{
    protected $tableName = 'UserRoles';
    protected $context;
    public function __construct()
    {
        $this->context = Database::getInstance();
    }
	/**
	 * @param mixed $username
	 * @return mixed
	 */
	public function GetRoleByUsername($username) 
    {
        $sql = "SELECT Roles.Name FROM UserRoles 
        JOIN Roles ON UserRoles.RoleId = Roles.Id 
        JOIN Users ON UserRoles.UserId = Users.UserId
        WHERE Users.Username = '$username'";
        $data = $this->context->fetch($sql);
        return $data;
	}
	
	/**
	 *
	 * @param mixed $roleName
	 * @return mixed
	 */
	public function GetUsernameByRole($roleName) {
        $sql = "SELECT Users.Username FROM UserRoles 
        JOIN Roles ON UserRoles.RoleId = Roles.Id 
        JOIN Users ON UserRoles.UserId = Users.UserId
        WHERE Roles.Name = '$roleName'";
        $data = $this->context->fetch($sql);
        return $data;
	}
	
	/**
	 *
	 * @param mixed $username
	 * @param mixed $roleName
	 * @return mixed
	 */
	public function AddRoleToUser($userId, $roleId) {
        $sql = "INSERT INTO UserRoles (UserId, RoleId) 
        VALUES ('$userId', '$roleId')";
        $this->context->query($sql);
	}
	
	/**
	 *
	 * @param mixed $username
	 * @param mixed $roleName
	 * @return mixed
	 */
	public function RemoveRoleFromUser($userId, $roleId) {
        $sql = "DELETE FROM UserRoles 
        WHERE UserId = '$userId' AND RoleId = '$roleId'";
        $this->context->query($sql);
	}
}