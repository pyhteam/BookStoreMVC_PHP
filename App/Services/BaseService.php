<?php 
namespace App\Services;
use App\Core\Database;

class BaseService
{
    protected $context;
    public function __construct()
    {
        $this->context = Database::getInstance();
    }
}