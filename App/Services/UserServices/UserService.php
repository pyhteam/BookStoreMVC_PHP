<?php

namespace App\Services\UserServices;

use App\Models\User;
use App\Services\BaseService;
use App\Services\Common\SqlCommon;

class UserService extends BaseService implements IUserService
{
	protected $tableName = 'Users';
	/**
	 * @param mixed $username
	 * @return mixed
	 */
	public function GetByUsername($username)
	{
		$sql = SqlCommon::Select_Condition($this->tableName, "WHERE Username = '$username'");
		$data =  $this->context->fetch_one($sql);
		$user = new User($data);
		return $user;
	}

	/**
	 *
	 * @param mixed $email
	 * @return mixed
	 */
	public function GetByEmail($email)
	{
		$sql = SqlCommon::Select_Condition($this->tableName, "WHERE Email = '$email'");
		$data =  $this->context->fetch_one($sql);
		$user = new User($data);
		return $user;
	}

	/**
	 * @return mixed
	 */
	public function GetAll()
	{
		$sql = SqlCommon::Select($this->tableName);
		$data = $this->context->fetch($sql);
		// to array object User
		$users = [];
		foreach ($data as $item) {
			$user = new User($item);
			array_push($users, $user);
		}
		return $users;
	}

	/**
	 *
	 * @param mixed $paginate
	 * @return mixed
	 */
	public function GetWithPaginate($pageIndex, $pageSize)
	{
		$offset = ($pageIndex - 1) * $pageSize;
		$sql = "
			SELECT Users.*, Roles.Name As RoleName,Roles.Id As RoleId FROM $this->tableName
			LEFT JOIN UsersRoles ON Users.Id = UsersRoles.UserId
			LEFT JOIN Roles ON UsersRoles.RoleId = Roles.Id
			LIMIT $pageSize OFFSET $offset
		";
		$data = $this->context->fetch($sql);
		// to array object User
		$users = [];
		foreach ($data as $item) {
			$user = new User($item);
			array_push($users, $user);
		}
		return $users;
	}

	/**
	 *
	 * @param mixed $id
	 * @return mixed
	 */
	public function GetById($id)
	{
		$sql = SqlCommon::SELECT_CONDITION($this->tableName, " WHERE Id = '$id'");
		$data = $this->context->fetch_one($sql);
		$user = new User($data);
		return $user;
	}

	/**
	 *
	 * @param mixed $data
	 * @return mixed
	 */
	public function Add($data)
	{
		// add default value to $data
		$data['CreatedAt'] = date('Y-m-d H:i:s');
		$data['CreatedBy'] = $data['CreatedBy'] ?? 'admin';

		$data['IsActive'] = $data['IsActive'] ?? 1;
		$sql = SqlCommon::Insert($this->tableName, $data);
		return $this->context->query($sql);
	}

	/**
	 *
	 * @param mixed $data
	 * @param mixed $id
	 * @return mixed
	 */
	public function Update($data, $id)
	{
		$data['UpdatedAt'] = date('Y-m-d H:i:s');
		$data['UpdatedBy'] = $data['UpdatedBy'] ?? 'admin';
		$sql = SqlCommon::Update($this->tableName, $data, $id);
		return $this->context->query($sql);
	}

	/**
	 *
	 * @param mixed $id
	 * @return mixed
	 */
	public function Delete($id)
	{
		$sql = SqlCommon::Delete($this->tableName, $id);
		return  $this->context->query($sql);
	}
}
