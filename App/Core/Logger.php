<?php
namespace App\Core;
class Logger
{
    protected $logPath;

    public function __construct($logPath = null)
    {
        if ($logPath === null) {
            $logPath = __DIR__ . '/../../Logs'; // Đường dẫn mặc định cho thư mục log
        }

        $this->logPath = $logPath;
    }

    public function log($message, $level = 'error')
    {
        $date = date('Ymd'); // Đổi 'dmY' thành 'Ymd' để tạo thư mục ngày tháng năm
        $logDir = $this->logPath . '/' . $date;

        // Kiểm tra nếu thư mục đã tồn tại hoặc tạo mới nếu chưa
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $filename = $logDir . '/' . $level . '.log';
        $logMessage = "[" . date('Y-m-d H:i:s') . "] [$level]: $message" . PHP_EOL;

        // Sử dụng cờ FILE_APPEND để ghi dữ liệu vào tệp mà không ghi đè
        file_put_contents($filename, $logMessage, FILE_APPEND);
    }
}
