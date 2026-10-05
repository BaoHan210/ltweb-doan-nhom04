<?php
namespace App\Data;

use App\Models\MonAn;

class KhoMonAn {
    private string $filePath;

    public function __construct(string $filePath) {
        $this->filePath = $filePath;
    }

    // Hàm lấy tất cả món ăn từ file JSON
    public function tatCa(): array {
        if (!file_exists($this->filePath)) {
            return [];
        }
        $content = file_get_contents($this->filePath);
        $data = json_decode($content, true) ?? [];
        
        return array_map(fn($item) => new MonAn($item), $data);
    }

    // Hàm tìm 1 món ăn theo ID
    public function timTheoId(string $id): ?MonAn {
        foreach ($this->tatCa() as $monAn) {
            if ($monAn->id === $id) {
                return $monAn;
            }
        }
        return null;
    }
}