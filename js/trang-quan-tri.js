/*
 * trang-quan-tri.js
 * Xử lý biểu đồ thống kê hoạt động cho trang quản trị
 */

document.addEventListener('DOMContentLoaded', () => {
    const canvasElement = document.getElementById('bieuDoHoatDong');
    
    if (!canvasElement) return;

    const ctx = canvasElement.getContext('2d');

    // Dữ liệu mẫu khớp theo biểu đồ hàng tuần (T2 -> CN)
    const dataHoatDong = {
        labels: ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'],
        datasets: [
            {
                label: 'Bài viết',
                data: [15, 22, 20, 28, 21, 29, 38],
                borderColor: '#198754', // Màu xanh lá chủ đạo
                backgroundColor: 'rgba(25, 135, 84, 0.1)',
                borderWidth: 2,
                tension: 0.4, // Tạo độ cong mềm mại cho đường gấp khúc
                fill: true
            },
            {
                label: 'Lượt thích',
                data: [8, 11, 10, 14, 12, 17, 20],
                borderColor: '#ffc107', // Màu vàng cam
                backgroundColor: 'rgba(255, 193, 7, 0.1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }
        ]
    };

    const config = {
        type: 'line',
        data: dataHoatDong,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false // Ẩn chú thích mặc định vì đã custom phía trên tiêu đề
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f0f0f0'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    };

    new Chart(ctx, config);
});