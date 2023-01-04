<table class="table table-bordered">
    <tr class="bg-dark text-light">
        <th>#</th>
        <th>Nama Material</th>
        <th>Jumlah Pengajuan</th>
        <th>Sumber Material</th>
        <th>Total Harga</th>
    </tr>
    <?php $i=1;
        $total = 0;
    foreach($data as $d){ 
    $proyek = $this->db->get_where('master_proyek',['id' => $d->proyek_id])->row();

        if($d->type == 1){
            $source = 'RAB';
            $proyek_name = $proyek->nama_proyek;
            $total += $d->jml_pengajuan * $d->harga;
            $harga = '<b>Rp. '.number_format($d->jml_pengajuan * $d->harga) .'</b> <br>
            <small class="text-primary">Rp. '. number_format($d->harga) .'</small>';

        } else if($d->type == 2){
            $source = 'Logistik Gudang';
            $proyek_name = $proyek->nama_proyek;
            $harga = '-';
        }

    ?>
    <tr>
        <td><?= $i++; ?></td>
        <td><b><?= $d->nama_material ?></b><br>
            <small class="text-success"><?= $d->kategori_produk ?></small>
        </td>
        <td><?= $d->jml_pengajuan .' '. $d->nama_satuan ?></td>
        <td class="text-center"><b><?= $source; ?></b> <br> <small class="text-danger">Proyek <?= $proyek_name ?></small></td>
        <td>
            <?=$harga ?>
        </td>
    </tr>
    <?php } ?>
    <tr>
        <th colspan="3">Total Harga</th>
        <th>Rp. <?= number_format($total) ?></th>
    </tr>
</table>