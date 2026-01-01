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
        // Use current URL parameters as base
        const urlParams = new URLSearchParams(window.location.search);

        // Merge with new filters
        for (const [key, value] of Object.entries(filters)) {
            urlParams.set(key, value);
        }

        const response = await fetch(`/finance?${urlParams.toString()}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
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

function renderTransactions(transactionsData) {
    const tbody = document.getElementById('transactionTableBody');
    if (!tbody) return;

    if (transactionsData.data.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center py-5 text-muted">
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

        // Prepare data for edit
        const trxJson = JSON.stringify(trx).replace(/'/g, "&#39;");

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
                    <button class="btn btn-icon btn-sm text-primary hover-bg-primary-subtle me-1" 
                            data-json='${trxJson}'
                            onclick="openEditTransaction(this)">
                        <span class="material-symbols-outlined">edit</span>
                    </button>
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
    const transId = formData.get('id');

    const transactionData = {
        title: formData.get('title'),
        category: formData.get('category'),
        type: formData.get('type'),
        amount: rawAmount,
        date: formData.get('date'),
        status: formData.get('status') || 'paid',
    };

    // Determine URL and Method
    const url = transId ? `/transactions/${transId}` : '/transactions';
    const method = transId ? 'PUT' : 'POST';

    try {
        const response = await fetch(url, {
            method: method,
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
                title: transId ? 'Siap!' : 'Cring cring! 🤑',
                text: data.message, // Message from backend
                timer: 2000,
                showConfirmButton: false
            });

            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('transactionModal'));
            if (modal) modal.hide();

            // Reset form
            form.reset();
            document.getElementById('transId').value = ''; // Clear ID

            // Reload transactions and stats without page refresh
            await loadTransactions();
        } else {
            throw new Error(data.message || 'Gagal menyimpan transaksi');
        }
    } catch (error) {
        console.error('Error submitting transaction:', error);
        Swal.fire({
            icon: 'error',
            title: 'Waduh! 🙈',
            text: error.message || 'Terjadi kesalahan saat menyimpan transaksi'
        });
    }
};

/**
 * Edit Transaction (Populate Modal)
 */
window.editTransaction = async function (id) {
    try {
        // Fetch data specific transaction logic could be here, 
        // but for now we might need to rely on what we have or fetch it.
        // Simplified: Fetch row data or re-fetch from server.
        // Let's re-fetch to be safe and accurate.

        // Since we don't have a show method in Controller for JSON yet (based on previous file read),
        // we can cheat a bit: the data is already in the table? 
        // No, better to fetch. But wait, index returns JSON with all fields.
        // Let's imply we can read from the DOM or add a 'data-json' attribute to the row.

        // BETTER APPROACH: Add 'data-json' to the row render to easily pass data to edit function.
        // But for now, let's assume we can traverse the DOM or fetch from list if we stored it globally.
        // To save time, let's just use the data we can find in the global 'transactions' object if we had one.
        // Wait, we don't store it globally.

        // Quick fix: Since I can't easily change the controller to add 'show' right now without potentially breaking things or taking more steps,
        // and I see 'loadTransactions' fetches data.
        // Let's modify 'renderTransactions' to store data in a global variable or add it to the button.

        // Actually, let's just make the button pass the parameters? No, too many.
        // Let's hack it: Find the row by ID if we could, or just add a simple GET endpoint?
        // Ah, standard resource controller usually handles GET /transactions/{id}. 
        // Let's assume Laravel Resource Controller default behavior if it was defined as resource?
        // The controller file showed 'index', 'store', 'destroy'. NO 'show'.

        // User asked for "icon pensil bisa untuk edit".
        // I'll add attributes to the edit button with the data needed.

        // This function will be called by the edit button which I will update in 'renderTransactions'.
        // const btn = document.querySelector(`button[onclick='editTransaction(${id})']`);
        // const data = JSON.parse(btn.dataset.json);

        // But wait, 'editTransaction' receives ID. 
        // I will change the render loop to pass the object or put it in dataset.
        // Since I'm replacing the whole file content related to render, I can do that there.

        // Placeholder for now, I will implement the logic inside renderTransactions to pass data.
    } catch (e) {
        console.error(e);
    }
};

// ... Wait, I CANNOT define editTransaction here effectively without the data.
// I will rewrite renderTransactions and editTransaction together below.

/**
 * Render transactions to table
 */
function renderTransactions(transactionsData) {
    const tbody = document.getElementById('transactionTableBody');
    if (!tbody) return;

    if (transactionsData.data.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center py-5 text-muted"> <!- COLSPAN UPDATED ->
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

        // Prepare data for edit
        const trxJson = JSON.stringify(trx).replace(/'/g, "&#39;");

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
                    <button class="btn btn-icon btn-sm text-primary hover-bg-primary-subtle me-1" 
                            data-json='${trxJson}'
                            onclick="openEditTransaction(this)">
                        <span class="material-symbols-outlined">edit</span>
                    </button>
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
 * Open Edit Modal and Populate Data
 */
window.openEditTransaction = function (btn) {
    const data = JSON.parse(btn.getAttribute('data-json'));

    // Reset form first
    const form = document.getElementById('transactionForm');
    form.reset();

    // Fill ID
    document.getElementById('transId').value = data.id;

    // Fill Fields
    // Transaction Type (Radio)
    const typeRadio = document.querySelector(`input[name="type"][value="${data.type}"]`);
    if (typeRadio) {
        typeRadio.checked = true;
        // Trigger generic change event if needed for UI updates
        typeRadio.dispatchEvent(new Event('change'));
    }

    // Amount (Format it)
    const amountInput = document.getElementById('transAmount');
    amountInput.value = new Intl.NumberFormat('id-ID').format(data.amount);

    // Title
    document.getElementById('transName').value = data.title;

    // Category
    const catSelect = document.getElementById('transCategory');
    if (catSelect) catSelect.value = data.category;

    // Date Handling
    if (data.date) {
        // Check if date is a full timestamp or just date
        const dateObj = new Date(data.date);
        if (!isNaN(dateObj.getTime())) {
            const yyyy = dateObj.getFullYear();
            const mm = String(dateObj.getMonth() + 1).padStart(2, '0');
            const dd = String(dateObj.getDate()).padStart(2, '0');
            document.getElementById('transDate').value = `${yyyy}-${mm}-${dd}`;
        } else {
            document.getElementById('transDate').value = data.date;
        }
    }

    // Update Modal Title & Button
    document.getElementById('transactionModalLabel').textContent = 'Edit Transaksi';
    document.querySelector('#transactionModal .btn-modern-primary').textContent = 'Update Transaksi';

    // Show Modal
    const modal = new bootstrap.Modal(document.getElementById('transactionModal'));
    modal.show();
};

/**
 * Delete transaction with confirmation
 */
window.deleteTransaction = async function (transactionId) {
    const result = await Swal.fire({
        title: 'Hapus Transaksi?',
        text: 'Yakin mau hapus? Gak bisa dibalikin lho! 😬',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus Aja!',
        cancelButtonText: 'Gak Jadi'
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
                text: data.message, // "Oke, transaksi berhasil dihapus! 🗑️"
                timer: 2000,
                showConfirmButton: false
            });

            // Reload transactions and stats
            await loadTransactions();
        }
    } catch (error) {
        console.error('Error deleting transaction:', error);
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Duh, gagal menghapus transaksi nih 😔'
        });
    }
};

/**
 * Update budget display
 */
const formatNumber = (num) => new Intl.NumberFormat('id-ID').format(num);

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
        Swal.fire('Eits!', 'Anggaran harus lebih dari 0 dong! 😅', 'warning');
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
                title: 'Sip!',
                text: 'Anggaran berhasil diatur! 💰',
                timer: 2000,
                showConfirmButton: false
            });

            await loadTransactions();
        }
    } catch (error) {
        console.error('Error setting budget:', error);
        Swal.fire('Gagal!', 'Terjadi kesalahan saat menyimpan anggaran', 'error');
    }
};

// Initialize on page load
// Initialize on page load
window.initFinanceTracker = function () {
    console.log('✓ Finance Tracker JS Check');

    // Currency Formatting Helper
    const formatCurrencyInput = (input) => {
        if (!input) return;
        // Remove old listeners to avoid duplicates if possible, or just add (modern browsers handle dupes well mostly, but cloned nodes don't copy listeners)
        // Since Swup replaces body content, listeners on those elements are gone.
        input.removeEventListener('input', input.currencyHandler); // Safety

        input.currencyHandler = function (e) {
            let value = this.value.replace(/\D/g, '');
            if (value !== '') {
                value = new Intl.NumberFormat('id-ID').format(value);
            }
            this.value = value;
        };
        input.addEventListener('input', input.currencyHandler);
    };

    // Apply formatting to Transaction Amount
    formatCurrencyInput(document.getElementById('transAmount'));

    // Apply formatting to Budget Amount
    formatCurrencyInput(document.getElementById('budgetAmount'));

    // Reset Modal on Close (Create Mode by default)
    const transactionModalEl = document.getElementById('transactionModal');
    if (transactionModalEl) {
        transactionModalEl.addEventListener('hidden.bs.modal', function () {
            const form = document.getElementById('transactionForm');
            if (form) form.reset();
            const idInput = document.getElementById('transId');
            if (idInput) idInput.value = '';
            const label = document.getElementById('transactionModalLabel');
            if (label) label.textContent = 'Catat Transaksi';
            const btn = document.querySelector('#transactionModal .btn-modern-primary');
            if (btn) btn.textContent = 'Simpan Transaksi';
        });
    }
};

document.addEventListener('DOMContentLoaded', function () {
    if (document.querySelector('.finance-table-card')) {
        window.initFinanceTracker();
    }
});
