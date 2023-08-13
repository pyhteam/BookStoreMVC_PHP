<?php 
namespace App\Services\PermissionServices;

use App\Models\Permission;
use App\Services\BaseService;
use App\Services\Common\SqlCommon;
class PermissionService extends BaseService implements IPermissionService
{
    protected $tableName = 'Permissions';
	/**
	 * @param mixed $key
	 * @return mixed
	 */
	public function GetByKey($key) {
        $sql = SqlCommon::Select_Condition($this->tableName, "WHERE Key = $key");
        $data =  $this->context->fetch_one($sql);
        $permisson = new Permission($data);
        return $permisson;
	}
	
	/**
	 * @return mixed
	 */
	public function GetAll() 
    {
        $sql = SqlCommon::SELECT($this->tableName);
        $data = $this->context->fetch($sql);
        $permissions = [];
        foreach ($data as $item) {
            $permission = new Permission($item);
            array_push($permissions, $permission);
        }
        return $permissions;
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
        $permissions = [];
        foreach ($data as $item) {
            $permission = new Permission($item);
            array_push($permissions, $permission);
        }
        return $permissions;
	}
	
	/**
	 *
	 * @param mixed $id
	 * @return mixed
	 */
	public function GetById($id) {
        $sql = SqlCommon::Select_Condition($this->tableName, "WHERE Id = $id");
        $data =  $this->context->fetch_one($sql);
        $permisson = new Permission($data);
        return $permisson;
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
	public function Update($data, $id) {
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
        $sql = SqlCommon::Delete($this->tableName, "WHERE Id = $id");
        return $this->context->query($sql);
	}
}