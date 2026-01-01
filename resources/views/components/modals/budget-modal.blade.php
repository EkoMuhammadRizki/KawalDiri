<div class="modal fade" id="budgetModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold font-montserrat" id="budgetModalLabel">Atur Anggaran</h5>
                    <p class="text-muted small mb-0">Kelola batas pengeluaran Anda.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-4">
                <form id="budgetForm">
                    <div class="mb-4">
                        <label for="budgetAmount" class="form-label fw-bold small">Total Anggaran</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted">Rp</span>
                            <input type="text" class="form-control border-start-0 ps-0" id="budgetAmount" name="budget" placeholder="1.000.000" inputmode="numeric">
                        </div>
                        <div class="form-text x-small">Masukkan jumlah target pengeluaran maksimal.</div>
                    </div>

                    <div class="mb-4">
                        <label for="budgetPeriod" class="form-label fw-bold small">Periode Anggaran</label>
                        <select class="form-select" id="budgetPeriod" name="period">
                            <option value="monthly" selected>Bulanan</option>
                            <option value="weekly">Mingguan</option>
                            <option value="yearly">Tahunan</option>
                        </select>
                    </div>

                    <div class="alert alert-primary d-flex gap-3 align-items-center border-0 bg-primary-subtle text-primary mb-0 rounded-3" role="alert">
                        <span class="material-symbols-outlined fs-5">info</span>
                        <div class="x-small fw-medium">
                            Mengubah anggaran akan mereset persentase penggunaan untuk periode yang sedang berjalan.
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
                <button type="button" class="btn btn-outline-secondary px-4 rounded-3 h-45px fw-bold small" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary-custom px-4 rounded-3 h-45px fw-bold small d-flex align-items-center gap-2" onclick="submitBudget()">
                    Simpan Anggaran
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .h-45px {
        height: 45px;
    }

    .font-montserrat {
        font-family: 'Montserrat', sans-serif !important;
    }
</style>