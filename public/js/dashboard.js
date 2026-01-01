/**
 * Dashboard JavaScript
 * Mengelola charts dan recent activities di dashboard
 */

let productivityChart = null;
let expenseChart = null;

/**
 * Initialize productivity chart (Line Chart)
 */
async function initProductivityChart() {
    try {
        const response = await fetch('/api/dashboard/productivity');
        const data = await response.json();

        const ctx = document.getElementById('productivityChart');
        if (!ctx) {
            console.warn('Productivity chart canvas not found');
            return;
        }

        // Destroy existing chart if any
        if (productivityChart) {
            productivityChart.destroy();
        }

        // Create Gradient
        let gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(99, 102, 241, 0.5)'); // Top color (Primary)
        gradient.addColorStop(1, 'rgba(99, 102, 241, 0.0)'); // Bottom color (Transparent)

        productivityChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels, // Assuming labels are already ['Minggu 1', 'Minggu 2', ...] from API
                datasets: [{
                    label: 'Produktivitas',
                    data: data.data,
                    borderColor: '#6366f1', // Primary Color
                    backgroundColor: gradient,
                    borderWidth: 3,
                    tension: 0.4, // Smooth Spline
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
                        display: false
                    },
                    tooltip: {
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
                            borderDash: [5, 5],
                            color: '#e2e8f0',
                            drawBorder: false,
                        },
                        ticks: {
                            padding: 10,
                            color: '#64748b',
                            font: {
                                family: "'Plus Jakarta Sans', sans-serif"
                            },
                            precision: 0
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

        console.log('✓ Productivity chart initialized');
    } catch (error) {
        console.error('Error initializing productivity chart:', error);
    }
}

/**
 * Initialize expense chart (Doughnut Chart)
 */
async function initExpenseChart() {
    try {
        const response = await fetch('/api/dashboard/expenses');
        const data = await response.json();

        const ctx = document.getElementById('expenseChart');
        if (!ctx) {
            console.warn('Expense chart canvas not found');
            return;
        }

        // Destroy existing chart if any
        if (expenseChart) {
            expenseChart.destroy();
        }

        // Chart colors
        const colors = [
            '#ef4444', // Red
            '#f59e0b', // Orange
            '#10b981', // Green
            '#3b82f6', // Blue
            '#8b5cf6', // Purple
            '#ec4899', // Pink
        ];

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
                        position: 'bottom',
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

        console.log('✓ Expense chart initialized');
    } catch (error) {
        console.error('Error initializing expense chart:', error);
    }
}

/**
 * Load recent activities
 */
/**
 * Load recent activities
 */
async function loadRecentActivities(page = 1) {
    try {
        const response = await fetch(`/api/dashboard/activities?page=${page}`);
        const data = await response.json();

        const container = document.getElementById('recentActivitiesContainer');
        if (!container) {
            console.warn('Recent activities container not found');
            return;
        }

        if (data.activities.length === 0) {
            container.innerHTML = `
                <div class="text-center py-5">
                    <span class="material-symbols-outlined text-muted fs-1 opacity-25 mb-3">event_busy</span>
                    <p class="text-muted mb-0">Belum ada aktivitas</p>
                </div>
            `;
            return;
        }

        let html = '';
        data.activities.forEach(activity => {
            if (activity.type === 'task') {
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

        // Render Pagination Controls
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

        container.innerHTML = html;
        console.log('✓ Recent activities loaded:', data.activities.length);

    } catch (error) {
        console.error('Error loading recent activities:', error);
    }
}

// Initialize on page load
// Initialize on page load
window.initDashboard = function () {
    console.log('✓ Dashboard JS initialized');
    // Initialize charts and activities
    initProductivityChart();
    initExpenseChart();
    loadRecentActivities();
};

document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('productivityChart')) {
        window.initDashboard();
    }
});
