<?php 
namespace App\Models;
use App\Models\Base\BaseModel;
use App\Services\Common\Helper;
class Role extends BaseModel
{
    // Properties
    public $Id;
    public $Name;
    public $Description;
    public function __construct($role)
    {
        $this->Id = $role['Id'];
        $this->Name = $role['Name'];
        $this->Description = $role['Description'];
        parent::__construct($role);
    }
}