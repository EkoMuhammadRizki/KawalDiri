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

        productivityChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Tugas Selesai',
                    data: data.data,
                    borderColor: 'rgb(99, 102, 241)',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    tension: 0.4,
                    fill: true,
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
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: 'rgba(99, 102, 241, 0.3)',
                        borderWidth: 1,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
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
async function loadRecentActivities() {
    try {
        const response = await fetch('/api/dashboard/activities');
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
                                    <span class="badge bg-${activity.priority === 'high' ? 'danger' : activity.priority === 'medium' ? 'warning' : 'secondary'}-subtle text-${activity.priority === 'high' ? 'danger' : activity.priority === 'medium' ? 'warning' : 'secondary'} me-2">${activity.priority}</span>
                                    ${activity.date}
                                </p>
                            </div>
                            <span class="badge bg-${activity.status === 'completed' ? 'success' : 'primary'}-subtle text-${activity.status === 'completed' ? 'success' : 'primary'}">${activity.status === 'completed' ? 'Selesai' : 'Pending'}</span>
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

        container.innerHTML = html;
        console.log('✓ Recent activities loaded:', data.activities.length);
    } catch (error) {
        console.error('Error loading recent activities:', error);
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function () {
    console.log('✓ Dashboard JS loaded');

    // Initialize charts and activities
    initProductivityChart();
    initExpenseChart();
    loadRecentActivities();
});
