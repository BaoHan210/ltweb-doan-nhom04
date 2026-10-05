<?php
namespace App\Models;

class MonAn {
    public string $id;
    public string $ten;
    public string $moTaNgan;
    public string $hinhAnh;

    public function __construct(array $data = []) {
        $this->id        = $data['id'] ?? '';
        $this->ten       = $data['tenMon'] ?? $data['ten'] ?? '';
        $this->moTaNgan  = $data['moTaNgan'] ?? '';
        $this->hinhAnh   = $data['hinhAnh'] ?? 'images/placeholder.jpg';
    }
}