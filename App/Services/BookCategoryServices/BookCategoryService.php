<?php 
namespace App\Services\BookCategoryServices;

use App\Models\BookCategory;
use App\Services\BaseService;
use App\Services\BookCategoryServices\IBookCategoryService;
use App\Services\Common\SqlCommon;
class BookCategoryService extends BaseService implements IBookCategoryService
{
    protected $tableName = 'BookCategory';
    /**
     * @return mixed
     */
    public function GetAll()
    {
        $sql = SqlCommon::SELECT($this->tableName);
        $data = $this->context->fetch($sql);
        $bookCategories = [];
        foreach ($data as $item) {
            $bookCategorie = new BookCategory($item);
            array_push($bookCategories, $bookCategorie);
        }
        return $bookCategories;
    }
	
	/**
	 *
	 * @param mixed $pageIndex
	 * @param mixed $pageSize
	 * @return mixed
	 */
	public function GetWithPaginate($pageIndex, $pageSize) {
        $offset = ($pageIndex - 1) * $pageSize;
        $sql = SqlCommon::SELECT_LIMIT($this->tableName, $offset, $pageSize);
        $data = $this->context->fetch($sql);
        $bookCategories = [];
        foreach ($data as $item) {
            $bookCategorie = new BookCategory($item);
            array_push($bookCategories, $bookCategorie);
        }
        return $bookCategories;
	}
	
	/**
	 *
	 * @param mixed $id
	 * @return mixed
	 */
	public function GetById($id) {
        $sql = SqlCommon::SELECT_CONDITION($this->tableName, "WHERE Id = '$id'");
        $data = $this->context->fetch_one($sql);
        $bookCategory = new BookCategory($data);
        return $bookCategory;
	}
	
	/**
	 *
	 * @param mixed $data
	 * @return mixed
	 */
	public function Add($data) {
        $data['CreatedAt'] = date('Y-m-d H:i:s');
        $data['CreatedBy'] = $data['CreatedBy'] ?? 'admin';

        $data['IsActive'] = $data['IsActive'] ?? 1;
        $sql = SqlCommon::INSERT($this->tableName, $data);
        return $this->context->query($sql)? true : false;
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
        $sql = SqlCommon::UPDATE($this->tableName, $data, $id);
        return $this->context->query($sql)? true : false;
	}
	
	/**
	 *
	 * @param mixed $id
	 * @return mixed
	 */
	public function Delete($id) {
        $sql = SqlCommon::DELETE($this->tableName, $id);
        return $this->context->query($sql)? true : false;
	}
}