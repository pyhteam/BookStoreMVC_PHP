<?php 

namespace App\Services\RoleServices;

use App\Models\Role;
use App\Services\BaseService;
use App\Services\Common\SqlCommon;
class RoleService extends BaseService implements IRoleService
{
	protected $tableName = 'Roles';
	/**
	 * @param mixed $name
	 * @return mixed
	 */
	public function GetByName($name) {
        $sql = SqlCommon::Select_Condition($this->tableName, "WHERE Name = $name");
        $data =  $this->context->fetch_one($sql);
        $role = new Role($data);
        return $role;
	}
	
	/**
	 * @return mixed
	 */
	public function GetAll() {
        $sql = SqlCommon::SELECT($this->tableName);
        $data = $this->context->fetch($sql);
        $roles = [];
        foreach ($data as $item) {
            $role = new Role($item);
            array_push($roles, $role);
        }
        return $roles;
	}
	
	/**
	 *
	 * @param mixed $paginate
	 * @return mixed
	 */
	public function GetWithPaginate($pageIndex, $pageSize) {
        $sql = SqlCommon::Select_Condition($this->tableName, "LIMIT $pageIndex, $pageSize");
        $data = $this->context->fetch($sql);
        // to array object role
        $roles = [];
        foreach ($data as $item) {
            $role = new Role($item);
            array_push($roles, $role);
        }
        return $roles;

	}
	
	/**
	 *
	 * @param mixed $id
	 * @return mixed
	 */
	public function GetById($id) 
    {
        $sql = SqlCommon::Select_Condition($this->tableName, "WHERE Id = $id");
        $data = $this->context->fetch_one($sql);
        $role = new Role($data);
        return $role;
	}
	
	/**
	 *
	 * @param mixed $data
	 * @return mixed
	 */
	public function Add($data) {
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
        $sql = SqlCommon::Update($this->tableName, $data, "WHERE Id = $id");
        return $this->context->query($sql);
	}
	
	/**
	 *
	 * @param mixed $id
	 * @return mixed
	 */
	public function Delete($id) {
        $sql = SqlCommon::Delete($this->tableName, "Id = $id");
        return  $this->context->query($sql);
	}
}