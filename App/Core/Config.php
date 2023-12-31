<?php

namespace App\Core;

class Config
{
    private $data = [];

    public function __construct()
    {
        // Load your configuration data here
        $this->loadConfig();
    }
    private function loadConfig()
    {
        // Example configuration data
        $this->data = [
            'app_name' => 'My PHPMVC App',
            'db_host' => 'localhost',
            'db_name' => 'bookstore_mvc',
            'db_user' => 'root',
            'db_password' => '',
            'timezone' => 'Asia/Ho_Chi_Minh',
        ];
    }
    public static function PageConfig()
    {
        return  [
            'PageSize' => 8,
            'PageIndex' => 0,
            'PageOption' => [10, 20, 50, 100],
        ];
    }

    public function get($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }
}
