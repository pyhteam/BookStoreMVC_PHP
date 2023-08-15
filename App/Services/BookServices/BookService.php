<?php 
namespace App\Services\BookServices;
use App\Models\Book;
use App\Services\BaseService;
use App\Services\Common\SqlCommon;
class BookService extends BaseService implements IBookService {

    protected $tableName = 'Book';
	/**
	 * @param mixed $CategoryId
	 * @param mixed $pageIndex
	 * @param mixed $pageSize
	 * @return mixed
	 */
	public function GetByCategory($CategoryId, $limit) {
       
        $sql = SqlCommon::SELECT_CONDITION($this->tableName, "
        WHERE CategoryId = '$CategoryId'
        ORDER BY CreatedAt DESC
        LIMIT  $limit");
        $data = $this->context->fetch($sql);
        $bookCategories = [];
        foreach ($data as $item) {
            $bookCategorie = new Book($item);
            array_push($bookCategories, $bookCategorie);
        }
        return $bookCategories;
	}
	
	/**
	 * @return mixed
	 */
	public function GetAll() {
        $sql = SqlCommon::SELECT($this->tableName);
        $data = $this->context->fetch($sql);
        $books = [];
        foreach ($data as $item) {
            $book = new Book($item);
            array_push($books, $book);
        }
        return $books;
	}
	
	/**
	 *
	 * @param mixed $pageIndex
	 * @param mixed $pageSize
	 * @return mixed
	 */
	public function GetWithPaginate($pageIndex, $pageSize) {
        $offset = ($pageIndex - 1) * $pageSize;
        $sql = "
			SELECT b.*, bc.Name AS CategoryName FROM $this->tableName b
			LEFT JOIN BookCategory bc ON b.CategoryId = bc.Id
			ORDER BY CreatedAt DESC
			LIMIT $offset, $pageSize
		";
        $data = $this->context->fetch($sql);
        $books = [];
        foreach ($data as $item) {
            $book = new Book($item);
            array_push($books, $book);
        }
        return $books;
	}
	
	/**
	 *
	 * @param mixed $id
	 * @return mixed
	 */
	public function GetById($id) {
        $sql = SqlCommon::SELECT_CONDITION($this->tableName, "WHERE Id = '$id'");
        $data = $this->context->fetch_one($sql);
        $book = new Book($data);
        return $book;
	}
	
	/**
	 *
	 * @param mixed $data
	 * @return mixed
	 */
	public function Add($data) {
        $data['CreatedAt'] = date('Y-m-d H:i:s');
        $data['CreatedBy'] = $data['CreatedBy'] ?? 'System';
        $data['IsActive'] = $data['IsActive'] ?? 1;
        $sql = SqlCommon::INSERT($this->tableName, $data);
        return $this->context->query($sql) ? true : false;
	}
	
	/**
	 *
	 * @param mixed $data
	 * @param mixed $id
	 * @return mixed
	 */
	public function Update($data, $id) {
        $data['UpdatedAt'] = date('Y-m-d H:i:s');
        $data['UpdatedBy'] = $data['UpdatedBy'] ?? 'System';
        $sql = SqlCommon::UPDATE($this->tableName, $data, $id);
        return $this->context->query($sql) ? true : false;
	}
	
	/**
	 *
	 * @param mixed $id
	 * @return mixed
	 */
	public function Delete($id) {
        $sql = SqlCommon::DELETE($this->tableName, $id);
        return $this->context->query($sql) ? true : false;
	}
	/**
	 * @param mixed $pageIndex
	 * @param mixed $pageSize
	 * @return mixed
	 */
	public function GetBookLastes($pageIndex, $pageSize) {
		$offset = ($pageIndex - 1) * $pageSize;
		$sql = "
			SELECT b.*, bc.Name AS CategoryName FROM $this->tableName b
			LEFT JOIN BookCategory bc ON b.CategoryId = bc.Id
			ORDER BY CreatedAt DESC
			LIMIT $offset, $pageSize
		";
		$data = $this->context->fetch($sql);
		$books = [];
		foreach ($data as $item) {
			$book = new Book($item);
			array_push($books, $book);
		}
		return $books;
	}
	
	/**
	 *
	 * @param mixed $limit
	 * @return mixed
	 */
	public function GetBestSeller($limit) {
		// order by TOP Book Best Seller from order detail 
		$sql = "
			SELECT b.*, bc.Name AS CategoryName, COUNT(od.BookId) AS Total FROM $this->tableName b
			JOIN BookCategory bc ON b.CategoryId = bc.Id
			JOIN OrderDetails od ON b.Id = od.BookId
			GROUP BY b.Id
			ORDER BY Total DESC
			LIMIT $limit
		";
		$data = $this->context->fetch($sql);
		$books = [];
		foreach ($data as $item) {
			$book = new Book($item);
			array_push($books, $book);
		}
		return $books;

	}
}