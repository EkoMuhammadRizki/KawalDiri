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

                <form id="transactionForm">
                    <div class="mb-4">
                        <label class="form-label modern-label d-block text-center mb-3">Jenis Transaksi</label>
                        <div class="segmented-control transaction-type">
                            <input type="radio" name="type" id="typeExpense" value="expense" checked>
                            <label for="typeExpense">Pengeluaran</label>

                            <input type="radio" name="type" id="typeIncome" value="income">
                            <label for="typeIncome">Pemasukan</label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="transAmount" class="form-label modern-label">Nominal</label>
                        <div class="currency-input-wrapper">
                            <span class="currency-symbol">Rp</span>
                            <input type="text" class="form-control form-control-modern input-large-currency" id="transAmount" name="amount" placeholder="0" inputmode="numeric">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="transName" class="form-label modern-label">Keterangan</label>
                        <input type="text" class="form-control form-control-modern" id="transName" name="title" placeholder="Contoh: Makan Siang">
                    </div>

                    <div class="row g-3 mb-2">
                        <div class="col-6">
                            <label for="transCategory" class="form-label modern-label">Kategori</label>
                            <select class="form-select form-select-modern" id="transCategory" name="category">
                                <option value="Makanan">Makanan</option>
                                <option value="Transportasi">Transportasi</option>
                                <option value="Belanja">Belanja</option>
                                <option value="Hiburan">Hiburan</option>
                                <option value="Tagihan">Tagihan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="transDate" class="form-label modern-label">Tanggal</label>
                            <input type="date" class="form-control form-control-modern" id="transDate" name="date" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer modern-footer">
                <button type="button" class="btn btn-modern-primary" onclick="submitTransaction()">Simpan Transaksi</button>
                <button type="button" class="btn btn-modern-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>