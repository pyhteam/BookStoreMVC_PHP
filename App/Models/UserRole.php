<?php 
namespace App\Models;
class UserRole 
{
    // Properties
    public $Id;
    public $UserId;
    public $RoleId;
    public function __construct($data)
    {
        $this->Id = $data['Id'];
        $this->UserId = $data['UserId'];
        $this->RoleId = $data['RoleId'];
    }
}