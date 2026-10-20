<?php
namespace App\Services;

class LienHeService
{
    public function __construct(private string $tepLog) {}

    // Trong src/Services/LienHeService.php
public function guiPhanHoi(array $data): bool
{
    if (empty($data['ho_ten']) || empty($data['email']) || empty($data['noi_dung'])) {
        return false;
    }

    // Ghi dữ liệu dưới dạng JSONL (mỗi phản hồi là 1 dòng JSON)
    $noiDungLog = json_encode($data, JSON_UNESCAPED_UNICODE) . "\n";

    return file_put_contents($this->tepLog, $noiDungLog, FILE_APPEND) !== false;
}
}
