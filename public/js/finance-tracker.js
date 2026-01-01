/**
 * Finance Tracker JavaScript
 * Mengelola interaksi antara UI dan backend untuk fitur Pelacak Keuangan
 */

// Helper function untuk get CSRF token
function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
}

/**
 * Load transactions from server
 */
async function loadTransactions(filters = {}) {
    try {
        const params = new URLSearchParams(filters);
        const response = await fetch(`/finance?${params}`, {
            headers: {
                'Accept': 'application/json',
            }
        });

        const data = await response.json();

        if (data.success) {
            console.log('✓ Transactions loaded:', data.transactions.data.length);
            updateBudgetDisplay(data.stats);
            renderTransactions(data.transactions);
        }
    } catch (error) {
        console.error('Error loading transactions:', error);
    }
}

/**
 * Render transactions to table
 */
function renderTransactions(transactionsData) {
    const tbody = document.getElementById('transactionTableBody');
    if (!tbody) return;

    if (transactionsData.data.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="4" class="text-center py-5 text-muted">
                    <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-state-2130362-1800926.png" alt="Empty" style="width: 150px; opacity: 0.5">
                    <p class="mt-3">Belum ada transaksi</p>
                </td>
            </tr>
        `;
        return;
    }

    let html = '';
    transactionsData.data.forEach(trx => {
        const isIncome = trx.type === 'income';
        const colorClass = isIncome ? 'text-success' : 'text-danger';
        const icon = isIncome ? 'trending_up' : 'trending_down';
        const amountSign = isIncome ? '+' : '-';

        html += `
            <tr>
                <td>
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle p-2 bg-${isIncome ? 'success' : 'danger'}-subtle text-${isIncome ? 'success' : 'danger'} d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                            <span class="material-symbols-outlined fs-5">${icon}</span>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">${trx.title}</h6>
                            <small class="text-muted">${trx.date}</small>
                        </div>
                    </div>
                </td>
                <td><span class="badge bg-light text-dark border">${trx.category}</span></td>
                <td>
                    <span class="badge bg-${trx.status === 'paid' ? 'success' : 'warning'}-subtle text-${trx.status === 'paid' ? 'success' : 'warning'} text-capitalize">
                        ${trx.status}
                    </span>
                </td>
                <td class="text-end fw-bold ${colorClass}">
                    ${amountSign} Rp ${new Intl.NumberFormat('id-ID').format(trx.amount)}
                </td>
                <td class="text-end">
                    <button class="btn btn-icon btn-sm text-danger hover-bg-danger-subtle" onclick="deleteTransaction(${trx.id})">
                        <span class="material-symbols-outlined">delete</span>
                    </button>
                </td>
            </tr>
        `;
    });

    tbody.innerHTML = html;
}

/**
 * Submit new transaction via modal
 */
window.submitTransaction = async function () {
    console.log('submitTransaction called');

    const form = document.getElementById('transactionForm');
    if (!form) {
        console.error('Transaction form not found');
        return;
    }

    const formData = new FormData(form);
    // Remove dots from amount for backend processing
    let rawAmount = formData.get('amount').toString().replace(/\./g, '');

    const transactionData = {
        title: formData.get('title'),
        category: formData.get('category'),
        type: formData.get('type'),
        amount: rawAmount,
        date: formData.get('date'),
        status: formData.get('status') || 'paid',
    };

    try {
        const response = await fetch('/transactions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json',
            },
            body: JSON.stringify(transactionData)
        });

        const data = await response.json();

        if (data.success) {
            await Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            });

            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('transactionModal'));
            if (modal) modal.hide();

            // Reset form
            form.reset();

            // Reload page
            window.location.reload();
        } else {
            throw new Error(data.message || 'Gagal menambahkan transaksi');
        }
    } catch (error) {
        console.error('Error submitting transaction:', error);
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: error.message || 'Terjadi kesalahan saat menambahkan transaksi'
        });
    }
};

/**
 * Delete transaction with confirmation
 */
window.deleteTransaction = async function (transactionId) {
    const result = await Swal.fire({
        title: 'Hapus Transaksi?',
        text: 'Transaksi yang dihapus tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    });

    if (!result.isConfirmed) return;

    try {
        const response = await fetch(`/transactions/${transactionId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json',
            }
        });

        const data = await response.json();

        if (data.success) {
            await Swal.fire({
                icon: 'success',
                title: 'Terhapus!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            });

            // Reload page
            window.location.reload();
        }
    } catch (error) {
        console.error('Error deleting transaction:', error);
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Terjadi kesalahan saat menghapus transaksi'
        });
    }
};

/**
 * Update budget display
 */
function updateBudgetDisplay(stats) {
    if (!stats) return;

    // Update budget percentage
    const percentEl = document.getElementById('budgetPercent');
    if (percentEl) {
        percentEl.textContent = stats.budget_used_percent + '%';
    }

    // Update circle progress (SVG)
    const circleProgress = document.querySelector('.circle-progress');
    if (circleProgress) {
        circleProgress.setAttribute('stroke-dasharray', `${stats.budget_used_percent}, 100`);
    }

    // Update text values
    const totalBudgetEl = document.querySelectorAll('[data-budget-total]');
    totalBudgetEl.forEach(el => {
        el.textContent = 'Rp ' + formatNumber(stats.budget);
    });

    const usedBudgetEl = document.querySelectorAll('[data-budget-used]');
    usedBudgetEl.forEach(el => {
        el.textContent = 'Rp ' + formatNumber(stats.monthly_expenses);
    });

    const remainingBudgetEl = document.querySelectorAll('[data-budget-remaining]');
    remainingBudgetEl.forEach(el => {
        el.textContent = 'Rp ' + formatNumber(stats.budget_remaining);
    });
}

/**
 * Set/Update user budget via modal
 */
/**
 * Submit budget setting
 */
window.submitBudget = async function () {
    const budgetInput = document.getElementById('budgetAmount');
    if (!budgetInput) return;

    // Remove dots for backend
    const budgetValue = budgetInput.value.replace(/\./g, '');

    if (!budgetValue || budgetValue <= 0) {
        Swal.fire('Error', 'Anggaran harus lebih dari 0!', 'error');
        return;
    }

    try {
        const response = await fetch('/settings/budget', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json',
            },
            body: JSON.stringify({ budget: budgetValue })
        });

        const data = await response.json();

        if (data.success) {
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('budgetModal'));
            if (modal) modal.hide();

            await Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            });

            window.location.reload();
        }
    } catch (error) {
        console.error('Error setting budget:', error);
        Swal.fire('Gagal!', 'Terjadi kesalahan saat menyimpan anggaran', 'error');
    }
};

// Initialize on page load
document.addEventListener('DOMContentLoaded', function () {
    console.log('✓ Finance Tracker JS loaded');

    // Currency Formatting Helper
    const formatCurrencyInput = (input) => {
        if (!input) return;
        input.addEventListener('input', function (e) {
            let value = this.value.replace(/\D/g, '');
            if (value !== '') {
                value = new Intl.NumberFormat('id-ID').format(value);
            }
            this.value = value;
        });
    };

    // Apply formatting to Transaction Amount
    formatCurrencyInput(document.getElementById('transAmount'));

    // Apply formatting to Budget Amount
    formatCurrencyInput(document.getElementById('budgetAmount'));
});
