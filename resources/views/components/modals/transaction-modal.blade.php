<!-- Transaction Modal -->
<div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="transactionModalLabel">Catat Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                <div class="text-center mb-4">
                    <div class="bg-secondary-subtle d-inline-flex p-3 rounded-circle mb-2">
                        <span class="material-symbols-outlined text-secondary fs-3">payments</span>
                    </div>
                    <p class="text-muted small">Catat pemasukan atau pengeluaran baru.</p>
                </div>

                <form id="createTransactionForm">
                    <div class="mb-3">
                        <label class="form-label small fw-medium d-block">Jenis Transaksi</label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="transType" id="typeExpense" autocomplete="off" checked>
                            <label class="btn btn-outline-danger" for="typeExpense">Pengeluaran</label>

                            <input type="radio" class="btn-check" name="transType" id="typeIncome" autocomplete="off">
                            <label class="btn btn-outline-success" for="typeIncome">Pemasukan</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="transAmount" class="form-label small fw-medium">Nominal</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">Rp</span>
                            <input type="number" class="form-control bg-light border-0" id="transAmount" placeholder="0">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="transName" class="form-label small fw-medium">Keterangan</label>
                        <input type="text" class="form-control bg-light border-0" id="transName" placeholder="Contoh: Makan Siang">
                    </div>

                    <div class="mb-3">
                        <label for="transCategory" class="form-label small fw-medium">Kategori</label>
                        <select class="form-select bg-light border-0" id="transCategory">
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
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-light w-100 mb-2" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-secondary-custom w-100" onclick="Swal.fire('Berhasil!', 'Transaksi telah dicatat.', 'success'); var myModal = bootstrap.Modal.getInstance(document.getElementById('transactionModal')); myModal.hide();">Simpan Transaksi</button>
            </div>
        </div>
    </div>
</div>