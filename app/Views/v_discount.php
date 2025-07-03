<?= $this->extend('layout'); ?>

<?= $this->section('content'); ?>
<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('failed')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('failed') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<button type="button" class="btn btn-primary mt-4 mb-3" data-bs-toggle="modal" data-bs-target="#addDiscountModal">
    <i class="bi bi-plus-circle"></i> Tambah Data Diskon
</button>

<div class="table-responsive">
    <table class="table datatable table-hover table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Nominal (Rp)</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php if (!empty($discount)) : ?>
                <?php foreach ($discount as $item) : ?>
                    <tr>
                        <th scope="row"><?= $i++; ?></th>
                        <td><?= esc($item['tanggal']); ?></td>
                        <td><?= number_format(esc($item['nominal']), 0, ',', '.'); ?></td>
                        <td>
                            <button type="button" class="btn btn-success btn-sm edit-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#editDiscountModal"
                                data-id="<?= esc($item['id']); ?>">
                                <i class="bi bi-pencil"></i> Ubah
                            </button>
                            <a href="<?= base_url('diskon/delete/' . esc($item['id'])); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus diskon ini?')">
                                <i class="bi bi-trash"></i> Hapus
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data diskon.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="addDiscountModal" tabindex="-1" aria-labelledby="addDiscountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pt-5" id="addDiscountModalLabel">Tambah Diskon Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('diskon/save'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tanggal_add" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal_add" name="tanggal" value="<?= old('tanggal'); ?>">
                        <?php if ($validation->hasError('tanggal')) : ?>
                            <div class="text-danger mt-1">
                                <?= $validation->getError('tanggal'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="nominal_add" class="form-label">Nominal (Rp)</label>
                        <input type="number" class="form-control" id="nominal_add" name="nominal" value="<?= old('nominal'); ?>" min="1">
                        <?php if ($validation->hasError('nominal')) : ?>
                            <div class="text-danger mt-1">
                                <?= $validation->getError('nominal'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editDiscountModal" tabindex="-1" aria-labelledby="editDiscountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDiscountModalLabel">Edit Diskon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editDiscountForm" action="" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="mb-3">
                        <label for="tanggal_edit" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal_edit" name="tanggal" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nominal_edit" class="form-label">Nominal (Rp)</label>
                        <input type="number" class="form-control" id="nominal_edit" name="nominal" min="1">
                        <?php if ($validation->hasError('nominal')) : ?>
                            <div class="text-danger mt-1">
                                <?= $validation->getError('nominal'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var editButtons = document.querySelectorAll('.edit-btn');
        var editDiscountModal = document.getElementById('editDiscountModal');
        var editDiscountForm = document.getElementById('editDiscountForm');
        var editIdInput = document.getElementById('edit_id');
        var editTanggalInput = document.getElementById('tanggal_edit');
        var editNominalInput = document.getElementById('nominal_edit');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                var discountId = this.dataset.id;
                
                fetch('<?= base_url('diskon/edit/') ?>' + discountId)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(data => {
                        editIdInput.value = data.id;
                        editTanggalInput.value = data.tanggal; 
                        editNominalInput.value = data.nominal;
                        editDiscountForm.action = '<?= base_url('diskon/update/') ?>' + data.id;
                    })
                    .catch(error => {
                        console.error('Error fetching discount data:', error);
                        alert('Gagal mengambil data diskon. Silakan coba lagi.');
                    });
            });
        });

        <?php if ($validation->getErrors()): ?>
            var errors = <?= json_encode($validation->getErrors()); ?>;
            var addModalOpen = false;
            var editModalOpen = false;

            if (errors.tanggal || errors.nominal) {
                <?php if (old('id') === null || old('id') === ''): ?>
                    addModalOpen = true;
                <?php else: ?>
                    editModalOpen = true;
                    document.getElementById('edit_id').value = '<?= old('id'); ?>';
                    document.getElementById('tanggal_edit').value = '<?= old('tanggal'); ?>';
                    document.getElementById('nominal_edit').value = '<?= old('nominal'); ?>';
                    document.getElementById('editDiscountForm').action = '<?= base_url('diskon/update/') . old('id'); ?>';
                <?php endif; ?>
            }

            if (addModalOpen) {
                var addModal = new bootstrap.Modal(document.getElementById('addDiscountModal'));
                addModal.show();
            } else if (editModalOpen) {
                var editModal = new bootstrap.Modal(document.getElementById('editDiscountModal'));
                editModal.show();
            }
        <?php endif; ?>

        // Optional: Inisialisasi Datatables (jika Anda menggunakannya)
        // Pastikan library Datatables sudah dimuat di layout.php
        /*
        if (typeof $.fn.DataTable !== 'undefined') {
            $('.datatable').DataTable({
                "pageLength": 10,
                "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
                }
            });
        }
        */
    });
</script>
<?= $this->endSection(); ?>