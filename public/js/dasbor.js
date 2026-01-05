/**
 * =================================================================
 * DASBOR.JS - Script Utama Dashboard KawalDiri
 * =================================================================
 * 
 * File ini mengelola semua komponen visual di halaman dashboard:
 * - Grafik Produktivitas (Line Chart) - menampilkan tugas selesai per minggu
 * - Grafik Pengeluaran (Doughnut Chart) - distribusi pengeluaran per kategori
 * - Aktivitas Terbaru - gabungan tugas dan transaksi terbaru
 * 
 * Dependencies:
 * - Chart.js untuk rendering grafik
 * - API endpoints: /api/dashboard/productivity, /api/dashboard/expenses, /api/dashboard/activities
 */

// Variabel global untuk menyimpan instance Chart.js
// Dibutuhkan agar bisa di-destroy dan di-reinitialize saat page reload (Swup)
let productivityChart = null;
let expenseChart = null;

/**
 * Inisialisasi Grafik Produktivitas (Line Chart)
 * 
 * Menampilkan jumlah tugas yang diselesaikan per minggu selama 4 minggu terakhir.
 * Grafik menggunakan efek gradient untuk visual yang menarik.
 */
async function initProductivityChart() {
    try {
        // Ambil data dari API
        const response = await fetch('/api/dashboard/productivity');
        const data = await response.json();

        // Cari elemen canvas untuk grafik
        const ctx = document.getElementById('productivityChart');
        if (!ctx) {
            console.warn('Productivity chart canvas not found');
            return;
        }

        // Hapus grafik yang ada (penting untuk Swup navigation)
        if (productivityChart) {
            productivityChart.destroy();
        }

        // Buat efek gradient dari atas ke bawah
        let gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(99, 102, 241, 0.5)');  // Warna atas (Primary ungu)
        gradient.addColorStop(1, 'rgba(99, 102, 241, 0.0)');  // Warna bawah (Transparan)

        // Konfigurasi dan buat grafik
        productivityChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,  // Label minggu dari API: ['Minggu 1', 'Minggu 2', ...]
                datasets: [{
                    label: 'Produktivitas',
                    data: data.data,
                    borderColor: '#6366f1',           // Warna garis (Primary)
                    backgroundColor: gradient,         // Fill area dengan gradient
                    borderWidth: 3,
                    tension: 0.4,                      // Kurva halus (spline)
                    fill: true,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#6366f1',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: '#6366f1',
                    pointHoverBorderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false  // Sembunyikan legend karena hanya 1 dataset
                    },
                    tooltip: {
                        // Styling tooltip saat hover
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#1e293b',
                        bodyColor: '#1e293b',
                        borderColor: '#e2e8f0',
                        borderWidth: 1,
                        padding: 12,
                        displayColors: false,
                        titleFont: {
                            size: 14,
                            family: "'Plus Jakarta Sans', sans-serif"
                        },
                        bodyFont: {
                            size: 13,
                            family: "'Plus Jakarta Sans', sans-serif",
                            weight: 'bold'
                        },
                        callbacks: {
                            // Format label tooltip dengan bahasa Indonesia
                            label: function (context) {
                                return context.parsed.y + ' Tugas Selesai';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            borderDash: [5, 5],   // Garis putus-putus
                            color: '#e2e8f0',
                            drawBorder: false,
                        },
                        ticks: {
                            padding: 10,
                            color: '#64748b',
                            font: {
                                family: "'Plus Jakarta Sans', sans-serif"
                            },
                            precision: 0  // Hanya angka bulat
                        },
                        border: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            padding: 10,
                            color: '#64748b',
                            font: {
                                family: "'Plus Jakarta Sans', sans-serif"
                            }
                        },
                        border: {
                            display: false
                        }
                    }
                },
                interaction: {
                    mode: 'index',
                    intersect: false,
                }
            }
        });

        console.log('✓ Grafik produktivitas berhasil diinisialisasi');
    } catch (error) {
        console.error('Error inisialisasi grafik produktivitas:', error);
    }
}

/**
 * Inisialisasi Grafik Pengeluaran (Doughnut Chart)
 * 
 * Menampilkan distribusi pengeluaran berdasarkan kategori dalam bentuk donat.
 * Warna berbeda untuk setiap kategori agar mudah dibedakan.
 */
async function initExpenseChart() {
    try {
        // Ambil data pengeluaran dari API
        const response = await fetch('/api/dashboard/expenses');
        const data = await response.json();

        // Cari elemen canvas
        const ctx = document.getElementById('expenseChart');
        if (!ctx) {
            console.warn('Expense chart canvas not found');
            return;
        }

        // Hapus grafik yang ada (penting untuk Swup navigation)
        if (expenseChart) {
            expenseChart.destroy();
        }

        // Palet warna untuk kategori pengeluaran
        const colors = [
            '#ef4444',  // Merah
            '#f59e0b',  // Orange
            '#10b981',  // Hijau
            '#3b82f6',  // Biru
            '#8b5cf6',  // Ungu
            '#ec4899',  // Pink
        ];

        // Konfigurasi dan buat grafik donat
        expenseChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: data.labels,
                datasets: [{
                    data: data.data,
                    backgroundColor: colors.slice(0, data.labels.length),
                    borderWidth: 2,
                    borderColor: '#fff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',  // Legenda di bawah grafik
                        labels: {
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        callbacks: {
                            // Format tooltip dengan currency Indonesia
                            label: function (context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed);
                                return label;
                            }
                        }
                    }
                }
            }
        });

        console.log('✓ Grafik pengeluaran berhasil diinisialisasi');
    } catch (error) {
        console.error('Error inisialisasi grafik pengeluaran:', error);
    }
}

/**
 * Memuat Aktivitas Terbaru
 * 
 * Menggabungkan tugas dan transaksi terbaru, dengan paginasi.
 * Setiap aktivitas ditampilkan dengan ikon dan warna sesuai tipenya.
 * 
 * @param {number} page - Nomor halaman untuk paginasi (default: 1)
 */
async function loadRecentActivities(page = 1) {
    try {
        // Ambil data aktivitas dari API dengan parameter page
        const response = await fetch(`/api/dashboard/activities?page=${page}`);
        const data = await response.json();

        // Cari container untuk menampilkan aktivitas
        const container = document.getElementById('recentActivitiesContainer');
        if (!container) {
            console.warn('Recent activities container not found');
            return;
        }

        // Tampilkan pesan jika tidak ada aktivitas
        if (data.activities.length === 0) {
            container.innerHTML = `
                <div class="text-center py-5">
                    <span class="material-symbols-outlined text-muted fs-1 opacity-25 mb-3">event_busy</span>
                    <p class="text-muted mb-0">Belum ada aktivitas</p>
                </div>
            `;
            return;
        }

        // Generate HTML untuk setiap aktivitas
        let html = '';
        data.activities.forEach(activity => {
            if (activity.type === 'task') {
                // Template untuk aktivitas tugas
                html += `
                    <div class="activity-item p-3 rounded-3 mb-2 hover-bg-light cursor-pointer">
                        <div class="d-flex align-items-center gap-3">
                            <div class="activity-icon bg-${activity.color}-subtle">
                                <span class="material-symbols-outlined text-${activity.color}">${activity.icon}</span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold">${activity.title}</h6>
                                <p class="small text-muted mb-0">
                                    <span class="badge bg-${activity.priority === 'high' ? 'danger' : activity.priority === 'medium' ? 'warning' : 'secondary'}-subtle text-${activity.priority === 'high' ? 'danger' : activity.priority === 'medium' ? 'warning' : 'secondary'}-emphasis me-2">${activity.priority}</span>
                                    ${activity.date}
                                </p>
                            </div>
                            <span class="badge bg-${activity.status === 'completed' ? 'success' : 'primary'}-subtle text-${activity.status === 'completed' ? 'success' : 'primary'}-emphasis">${activity.status === 'completed' ? 'Selesai' : 'Pending'}</span>
                        </div>
                    </div>
                `;
            } else if (activity.type === 'transaction') {
                // Template untuk aktivitas transaksi
                html += `
                    <div class="activity-item p-3 rounded-3 mb-2 hover-bg-light cursor-pointer">
                        <div class="d-flex align-items-center gap-3">
                            <div class="activity-icon bg-${activity.color}-subtle">
                                <span class="material-symbols-outlined text-${activity.color}">${activity.icon}</span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold">${activity.title}</h6>
                                <p class="small text-muted mb-0">
                                    <span class="badge bg-light text-dark me-2">${activity.category}</span>
                                    ${activity.date}
                                </p>
                            </div>
                            <span class="fw-bold text-${activity.transaction_type === 'income' ? 'success' : 'danger'}">${activity.amount}</span>
                        </div>
                    </div>
                `;
            }
        });

        // Tambahkan kontrol paginasi jika ada data paginasi
        if (data.pagination) {
            const paginationHtml = `
                <div class="d-flex justify-content-between align-items-center mt-3 custom-pagination-controls">
                    <button class="btn btn-sm btn-outline-secondary rounded-pill px-3" 
                            onclick="loadRecentActivities(${data.pagination.current_page - 1})"
                            ${data.pagination.current_page <= 1 ? 'disabled' : ''}>
                        <span class="material-symbols-outlined fs-6 align-middle">chevron_left</span> Prev
                    </button>
                    <span class="small text-muted fw-medium">Page ${data.pagination.current_page}</span>
                    <button class="btn btn-sm btn-outline-secondary rounded-pill px-3" 
                            onclick="loadRecentActivities(${data.pagination.current_page + 1})"
                            ${!data.pagination.has_more ? 'disabled' : ''}>
                        Next <span class="material-symbols-outlined fs-6 align-middle">chevron_right</span>
                    </button>
                </div>
            `;
            html += paginationHtml;
        }

        // Render HTML ke container
        container.innerHTML = html;
        console.log('✓ Aktivitas terbaru berhasil dimuat:', data.activities.length);

    } catch (error) {
        console.error('Error memuat aktivitas terbaru:', error);
    }
}

/**
 * Fungsi Inisialisasi Dashboard
 * 
 * Dipanggil saat halaman dashboard pertama kali dimuat atau
 * saat navigasi Swup ke halaman dashboard.
 * Menginisialisasi semua grafik dan memuat aktivitas terbaru.
 */
window.initDashboard = function () {
    console.log('✓ Dashboard JS diinisialisasi');

    // Inisialisasi semua komponen
    initProductivityChart();   // Grafik produktivitas
    initExpenseChart();        // Grafik pengeluaran
    loadRecentActivities();    // Aktivitas terbaru
};

// Auto-inisialisasi saat DOM ready (untuk akses langsung, bukan via Swup)
document.addEventListener('DOMContentLoaded', function () {
    // Hanya inisialisasi jika canvas grafik produktivitas ada (artinya di halaman dashboard)
    if (document.getElementById('productivityChart')) {
        window.initDashboard();
    }
});
