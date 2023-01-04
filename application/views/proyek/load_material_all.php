<?php foreach($proyek as $p){ 
    $date = date_create($p->tgl_pengajuan);    
?>
    <tr>
        <td><?= date_format($date, 'd F Y'); ?></td>
        <td><?= $p->nama_proyek ?></td>
        <td><b><?= $p->nama_material ?></b> <br>
            <small class="text-danger"><?= $p->kategori_produk ?></small>
        </td>
        <td><?= $p->jml_pengajuan .' '. $p->nama_satuan ?></td>
        <td><b>Rp. <?= number_format($p->harga_real * $p->jml_pengajuan) ?></b> <br>
            <small class="text-danger">(Rp. <?= number_format($p->harga_real) ?>)</small>
        </td>
        <td>
            <button class="btn btn-sm btn-success select-to-nota" data-id="<?= $p->logistik_id ?>"><i class="fa fa-check"></i></button>
        </td>
    </tr>
<?php } ?>
