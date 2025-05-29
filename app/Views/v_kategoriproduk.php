<?= $this->extend('layout') ?>
<?= $this->section('content') ?> 
<?php
if (session()->getFlashData('success')) {
?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
?>
<?php
if (session()->getFlashData('failed')) {
?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('failed') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
?>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
    Tambah Data
</button>
<!-- Table with stripped rows -->
<table class="table datatable">
    <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">Nama Kategori</th>
            <th scope="col">Nama Produk</th>
            <th scope="col">Deskripsi</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($productcategory as $index => $Productcategory) : ?>
            <tr>
                <th scope="row"><?php echo $index + 1 ?></th>
                <td><?php echo $Productcategory['nama_kategori'] ?></td>
                <td><?php echo $Productcategory['nama_product'] ?></td>
                <td><?php echo $Productcategory['deskripsi'] ?></td>
                <td>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal-<?= $Productcategory['id'] ?>">
                    Ubah
                </button>
                <a href="<?= base_url('kategoriproduk/delete/' . $Productcategory['id']) ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus data ini ?')">
                    Hapus
                </a>
                </td>
            </tr>
            <!-- Edit Modal Begin -->
<div class="modal fade" id="editModal-<?= $Productcategory['id'] ?>" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('kategoriproduk/edit/' . $Productcategory['id']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control" id="nama_kategori" value="<?= $Productcategory['nama_kategori'] ?>" placeholder="Nama Kategori" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Nama Produk</label>
                        <input type="text" name="nama_product" class="form-control" id="nama_product" value="<?= $Productcategory['nama_product'] ?>" placeholder="Nama Produk" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Deskripsi</label>
                        <input type="text" name="deskripsi" class="form-control" id="deskripsi" value="<?= $Productcategory['deskripsi'] ?>" placeholder="Deskripsi" required>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Edit Modal End -->
        <?php endforeach ?>
    </tbody>
</table>
<!-- End Table with stripped rows --> 
 <!-- Add Modal Begin -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('kategoriproduk') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="modal-body">
                <div class="form-group">
                        <label for="name">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control" id="nama_kategori" placeholder="Nama Kategori" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Nama Produk</label>
                        <input type="text" name="nama_product" class="form-control" id="nama_product" placeholder="Nama Produk" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Deskripsi</label>
                        <input type="text" name="deskripsi" class="form-control" id="deskripsi" placeholder="Deskripsi" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add Modal End -->
<?= $this->endSection() ?>