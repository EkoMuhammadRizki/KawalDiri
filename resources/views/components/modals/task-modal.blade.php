<!-- Task Modal -->
<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="taskModalLabel">Buat Tugas Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                <div class="text-center mb-4">
                    <div class="bg-primary-subtle d-inline-flex p-3 rounded-circle mb-2">
                        <span class="material-symbols-outlined text-primary fs-3">add_task</span>
                    </div>
                    <p class="text-muted small">Isi detail tugas di bawah ini untuk tetap terorganisir.</p>
                </div>

                <form id="createTaskForm">
                    <div class="mb-3">
                        <label for="taskName" class="form-label small fw-medium">Nama Tugas</label>
                        <input type="text" class="form-control bg-light border-0" id="taskName" placeholder="Contoh: Selesaikan Laporan Q3">
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label for="taskCategory" class="form-label small fw-medium">Kategori</label>
                            <select class="form-select bg-light border-0" id="taskCategory">
                                <option>Kerja</option>
                                <option>Pribadi</option>
                                <option>Kesehatan</option>
                                <option>Belajar</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="taskPriority" class="form-label small fw-medium">Prioritas</label>
                            <select class="form-select bg-light border-0" id="taskPriority">
                                <option value="high">Tinggi</option>
                                <option value="medium">Sedang</option>
                                <option value="low">Rendah</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="taskDueDate" class="form-label small fw-medium">Tenggat Waktu</label>
                        <input type="date" class="form-control bg-light border-0" id="taskDueDate">
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-light w-100 mb-2" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary w-100" onclick="Swal.fire('Berhasil!', 'Tugas baru telah ditambahkan.', 'success'); var myModal = bootstrap.Modal.getInstance(document.getElementById('taskModal')); myModal.hide();">Simpan Tugas</button>
            </div>
        </div>
    </div>
</div>