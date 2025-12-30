<!-- Transaction Modal -->
<div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modern-modal">
            <div class="modal-header modern-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modern-body pt-0">
                <div class="text-center mb-4">
                    <div class="modal-hero-icon" style="background: rgba(16, 185, 129, 0.1); color: #10B981;">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                    <h5 class="fw-bold mb-1" id="transactionModalLabel">Catat Transaksi</h5>
                    <p class="text-muted small">Catat pemasukan atau pengeluaran baru.</p>
                </div>

                <form id="createTransactionForm">
                    <div class="mb-4">
                        <label class="form-label modern-label d-block text-center mb-3">Jenis Transaksi</label>
                        <div class="segmented-control transaction-type">
                            <input type="radio" name="transType" id="typeExpense" value="expense" checked>
                            <label for="typeExpense">Pengeluaran</label>

                            <input type="radio" name="transType" id="typeIncome" value="income">
                            <label for="typeIncome">Pemasukan</label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="transAmount" class="form-label modern-label">Nominal</label>
                        <div class="currency-input-wrapper">
                            <span class="currency-symbol">Rp</span>
                            <input type="number" class="form-control form-control-modern input-large-currency" id="transAmount" placeholder="0">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="transName" class="form-label modern-label">Keterangan</label>
                        <input type="text" class="form-control form-control-modern" id="transName" placeholder="Contoh: Makan Siang">
                    </div>

                    <div class="mb-2">
                        <label for="transCategory" class="form-label modern-label">Kategori</label>
                        <select class="form-select form-select-modern" id="transCategory">
                            <option>Makanan</option>
                            <option>Transportasi</option>
                            <option>Belanja</option>
                            <option>Hiburan</option>
                            <option>Tagihan</option>
                            <option>Lainnya</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer modern-footer">
                <button type="button" class="btn btn-modern-primary" onclick="Swal.fire('Berhasil!', 'Transaksi telah dicatat.', 'success'); var myModal = bootstrap.Modal.getInstance(document.getElementById('transactionModal')); myModal.hide();">Simpan Transaksi</button>
                <button type="button" class="btn btn-modern-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>