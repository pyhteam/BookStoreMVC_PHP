<?php 
namespace App\Models;

use App\Models\Base\BaseModel;

class BookCategory extends BaseModel{
    public $Name;
    public $Slug;
    public  function __construct($bookCategory){
        $this->Name = $bookCategory['Name'];
        $this->Slug = $bookCategory['Slug'];
        parent::__construct($bookCategory);
    }
}
