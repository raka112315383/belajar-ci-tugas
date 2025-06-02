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
            <th scope="col">nama_kategori</th>
            <th scope="col">deskripsi</th>
            
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ProductCategory as $index => $ProductCategory) : ?>
            <tr>
                <th scope="row"><?php echo $index + 1 ?></th>
                <td><?php echo $ProductCategory['nama_kategori'] ?></td>
                <td><?php echo $ProductCategory['deskripsi'] ?></td>
              
                <td>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal-<?= $ProductCategory['id'] ?>">
    Ubah
</button>
<a href="<?= base_url('ProductCategory/delete/' . $ProductCategory['id']) ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus data ini ?')">
    Hapus
</a>
                </td>
            </tr>
            <!-- Edit Modal Begin -->
<div class="modal fade" id="editModal-<?= $ProductCategory['id'] ?>" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('ProductCategory/edit/' . $ProductCategory['id']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">nama kategori</label>
                        <input type="text" name="nama" class="form-control" id="nama"  placeholder="Nama Barang" required>
                    </div>
                    <div class="form-group">
                        <label for="name">deskripsi</label>
                        <input type="text" name="harga" class="form-control" id="harga"  placeholder="Harga Barang" required>
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
        

</table>
<!-- End Table with stripped rows -->
 <!-- Add Modal Begin -->
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
                        <label for="name">Nama</label>
                        <input type="text" name="nama_kategori" class="form-control" id="nama_kategori" placeholder="nama_kategori" required>
                    </div>
                    <div class="form-group">
                        <label for="name">deskripsi</label>
                        <input type="text" name="deskripsi" class="form-control" id="deskripsi" placeholder="deskripsi" required>
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

<!-- Add Modal End --> 
<?= $this->endSection() ?>