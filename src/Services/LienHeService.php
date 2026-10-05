<?php
namespace App\Services;

class LienHeService
{
    public function __construct(private string $tepLog) {}

    public function guiPhanHoi(array $data): bool
    {
        if (empty($data['ho_ten']) || empty($data['email']) || empty($data['noi_dung'])) {
            return false;
        }

        $noiDungLog = sprintf(
            "[%s] %s (%s): %s\n",
            date('Y-m-d H:i:s'),
            $data['ho_ten'],
            $data['email'],
            $data['noi_dung']
        );

        return file_put_contents($this->tepLog, $noiDungLog, FILE_APPEND) !== false;
    }
}