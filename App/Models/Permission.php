<?php 
namespace App\Models;
use App\Models\Base\BaseModel;
class Permission extends BaseModel
{
    // Properties
    public $Key;
    public $Value;
    public function __construct($data)
    {
        $this->Key = $data['Key'];
        $this->Value = $data['Value'];
        parent::__construct($data);
    }
}