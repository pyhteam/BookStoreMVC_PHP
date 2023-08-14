<?php

namespace App\Models;

use App\Models\Base\BaseModel;

class Book extends BaseModel
{
    // Properties
    public $Title;
    public $Slug;
    public $Author;
    public $CategoryId;
    public $CategoryName; // This property is not in the database
    public $Price;
    public $Quantity;
    public $Description;
    public $Image;
    public function __construct($data)
    {
        $this->Title = $data['Title'];
        $this->Slug = $data['Slug'];
        $this->Author = $data['Author'];
        $this->CategoryId = $data['CategoryId'];
        $this->Price = $data['Price'];
        $this->Quantity = $data['Quantity'];
        $this->Description = $data['Description'];
        $this->Image = $data['Image'];
        $this->CategoryName = $data['CategoryName'] ?? '';
        parent::__construct($data);
    }
}
