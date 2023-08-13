<?php

namespace App\Models;
use App\Models\Base\BaseModel;
class User extends BaseModel
{
    // Properties
    public $Username;
    public $Email;
    public $Password;
    public $FullName;
    public $Phone; 
    public $Avatar;
    // constructor
    public function __construct($user)
    {
        $this->Username = $user['Username'];
        $this->Email = $user['Email'];
        $this->Password = $user['Password'];
        $this->FullName = $user['FullName'];
        $this->Phone = $user['Phone'];
        $this->Avatar = $user['Avatar'];
        parent::__construct($user);
        
    }
}
