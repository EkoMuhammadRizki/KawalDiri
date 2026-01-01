<!-- Task Modal -->
<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modern-modal">
            <div class="modal-header modern-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modern-body pt-0">
                <div class="text-center mb-4">
                    <div class="modal-hero-icon">
                        <span class="material-symbols-outlined">add_task</span>
                    </div>
                    <h5 class="fw-bold mb-1" id="taskModalLabel">Buat Tugas Baru</h5>
                    <p class="text-muted small">Isi detail tugas di bawah ini untuk tetap terorganisir.</p>
                </div>

                <form id="taskForm">
                    <div class="mb-4">
                        <label for="taskName" class="form-label modern-label">Nama Tugas</label>
                        <input type="text" class="form-control form-control-modern" id="taskName" name="title" placeholder="Contoh: Selesaikan Laporan Q3">
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <label for="taskCategory" class="form-label modern-label">Kategori</label>
                            <select class="form-select form-select-modern" id="taskCategory" name="description">
                                <option value="Kerja">Kerja</option>
                                <option value="Pribadi">Pribadi</option>
                                <option value="Kesehatan">Kesehatan</option>
                                <option value="Belajar">Belajar</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="taskPriority" class="form-label modern-label">Prioritas</label>
                            <select class="form-select form-select-modern" id="taskPriority" name="priority">
                                <option value="high">Tinggi</option>
                                <option value="medium">Sedang</option>
                                <option value="low">Rendah</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="taskDueDate" class="form-label modern-label">Tenggat Waktu</label>
                        <input type="date" class="form-control form-control-modern" id="taskDueDate" name="due_date">
                    </div>
                </form>
            </div>
            <div class="modal-footer modern-footer">
                <button type="button" class="btn btn-modern-primary" onclick="submitTask()">Simpan Tugas</button>
                <button type="button" class="btn btn-modern-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>