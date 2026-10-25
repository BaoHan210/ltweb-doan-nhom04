
/*
 * trang-quan-tri.js
 * Xử lý biểu đồ thống kê hoạt động cho trang quản trị.
 */

document.addEventListener('DOMContentLoaded', () => {
    const canvasElement = document.getElementById('bieuDoHoatDong');

    // Dừng nếu trang hiện tại không có biểu đồ quản trị.
    if (!canvasElement) {
        return;
    }

    // Kiểm tra thư viện Chart.js đã được nạp.
    if (typeof Chart === 'undefined') {
        console.error(
            'Không thể khởi tạo biểu đồ: thư viện Chart.js chưa được nạp.'
        );
        return;
    }

    // Tránh khởi tạo biểu đồ nhiều lần trên cùng một canvas.
    if (Chart.getChart(canvasElement)) {
        return;
    }

    const ctx = canvasElement.getContext('2d');

    if (!ctx) {
        console.error(
            'Không thể khởi tạo biểu đồ: không lấy được ngữ cảnh 2D.'
        );
        return;
    }

    // Dữ liệu minh họa theo ngày trong tuần (T2 đến CN).
    const dataHoatDong = {
        labels: ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'],

        datasets: [
            {
                label: 'Bài viết',
                data: [15, 22, 20, 28, 21, 29, 38],
                borderColor: '#198754',
                backgroundColor: 'rgba(25, 135, 84, 0.1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            },
            {
                label: 'Lượt thích',
                data: [8, 11, 10, 14, 12, 17, 20],
                borderColor: '#ffc107',
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

            interaction: {
                mode: 'index',
                intersect: false
            },

            plugins: {
                // Sử dụng chú thích HTML đã có trong trang.
                legend: {
                    display: false
                },

                tooltip: {
                    enabled: true
                }
            },

            scales: {
                y: {
                    beginAtZero: true,

                    ticks: {
                        precision: 0
                    },

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
