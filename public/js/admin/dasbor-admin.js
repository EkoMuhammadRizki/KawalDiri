/**
 * Admin Dashboard JavaScript
 * Script untuk chart dan visualisasi data di admin dashboard
 */

// Inisialisasi Chart.js saat DOM loaded
document.addEventListener('DOMContentLoaded', function () {
    // Activity Chart - Menampilkan data aktivitas user 30 hari terakhir
    new Chart(document.getElementById('activityChart'), {
        type: 'line',
        data: {
            labels: Array.from({
                length: 30
            }, (_, i) => `${i + 1} Dec`),
            datasets: [{
                label: 'Active Users',
                data: [120, 150, 180, 160, 200, 220, 190, 210, 250, 230, 260, 240, 280, 290, 270, 300, 310, 290, 320, 330, 310, 340, 350, 330, 360, 370, 350, 380, 390, 400],
                borderColor: '#4338CA',
                backgroundColor: 'rgba(67, 56, 202, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        borderDash: [5, 5]
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});
