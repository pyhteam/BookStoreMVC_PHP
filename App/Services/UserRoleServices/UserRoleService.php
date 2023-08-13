<?php 
namespace App\Services\UserRoleServices;
use App\Core\Database;
class UserRoleService implements IUserRoleService
{
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
        $sql = "SELECT Roles.Name,Roles.Id FROM  UsersRoles 
        JOIN Roles ON  UsersRoles.RoleId = Roles.Id 
        JOIN Users ON  UsersRoles.UserId = Users.Id
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
        $sql = "SELECT Users.Username FROM  UsersRoles 
        JOIN Roles ON  UsersRoles.RoleId = Roles.Id 
        JOIN Users ON  UsersRoles.UserId = Users.Id
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
        $sql = "INSERT INTO UsersRoles (Id,UserId, RoleId) 
        VALUES (UUID(),'$userId', '$roleId')";
        $this->context->query($sql);
	}
	
	/**
	 *
	 * @param mixed $username
	 * @param mixed $roleName
	 * @return mixed
	 */
	public function RemoveRoleFromUser($userId, $roleId) {
        $sql = "DELETE FROM UsersRoles 
        WHERE UserId = '$userId' AND RoleId = '$roleId'";
        $this->context->query($sql);
	}
}