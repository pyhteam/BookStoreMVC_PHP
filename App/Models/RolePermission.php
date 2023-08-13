<?php 
namespace App\Models;

class RolePermission
{
    // Properties
    public $Id;
    public $PermissionId;
    public $RoleId;
    public function __construct($data)
    {
        $this->Id = $data['Id'];
        $this->PermissionId = $data['PermissionId'];
        $this->RoleId = $data['RoleId'];
    }
}