<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<?php
if (session()->getFlashData('success')) {
?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
?>
<?php echo form_open('keranjang/edit') ?>
<table class="table datatable">
    <thead>
        <tr>
            <th scope="col">Nama</th>
            <th scope="col">Foto</th>
            <th scope="col">Harga Asli</th> <th scope="col">Diskon Diterapkan</th> <th scope="col">Harga Setelah Diskon</th> <th scope="col">Jumlah</th>
            <th scope="col">Subtotal</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        if (!empty($items)) :
            foreach ($items as $index => $item) :
        ?>
                <tr>
                    <td><?php echo $item['name'] ?></td>
                    <td><img src="<?php echo base_url() . "img/" . $item['options']['foto'] ?>" width="100px"></td>
                    <td>
                        <?php 
                        if (isset($item['options']['original_price'])) {
                            echo number_to_currency($item['options']['original_price'], 'IDR');
                        } else {
                            // Fallback jika original_price tidak tersedia (misal: produk lama di keranjang)
                            echo number_to_currency($item['price'] + (isset($item['options']['applied_discount']) ? $item['options']['applied_discount'] : 0), 'IDR');
                        }
                        ?>
                    </td>
                    <td>
                        <?php 
                        if (isset($item['options']['applied_discount']) && $item['options']['applied_discount'] > 0) {
                            echo "- " . number_to_currency($item['options']['applied_discount'], 'IDR');
                        } else {
                            echo "Tidak ada";
                        }
                        ?>
                    </td>
                    <td><?php echo number_to_currency($item['price'], 'IDR') ?></td>
                    <td><input type="number" min="1" name="qty<?php echo $i++ ?>" class="form-control" value="<?php echo $item['qty'] ?>"></td>
                    <td><?php echo number_to_currency($item['subtotal'], 'IDR') ?></td>
                    <td>
                        <a href="<?php echo base_url('keranjang/delete/' . $item['rowid'] . '') ?>" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
        <?php
            endforeach;
        endif;
        ?>
    </tbody>
</table>
<div class="alert alert-info">
    <?php echo "Total = " . number_to_currency($total, 'IDR') ?>
</div>

<button type="submit" class="btn btn-primary">Perbarui Keranjang</button>
<a class="btn btn-warning" href="<?php echo base_url() ?>keranjang/clear">Kosongkan Keranjang</a>
<?php if (!empty($items)) : ?>
    <a class="btn btn-success" href="<?php echo base_url() ?>checkout">Selesai Belanja</a>
<?php endif; ?>
<?php echo form_close() ?>
<?= $this->endSection() ?>