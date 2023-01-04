<tr>
    <td class="text-center"><b><?= $data->nama_toko ?></b> <br> <small class="text-danger"><?= $data->alamat ?></small></td>
    <td class="text-center"><b><?= $data->nama ?></b> <br> <small class="text-success"><?= $data->no_tlp ?></small></td>
    <td class="text-center"><b><?= $data->nama_bank ?></b> <br> <span><?= $data->no_rek ?></span> <br> <small class="text-info"><?= $data->atas_nama ?></small></td>
    <td class="text-center">
        <?php foreach($nota as $n){ ?>
            <img src="<?= base_url('assets/bukti_pembayaran/') . $n->nota ?>" width="30%" alt="nota pembayaran">
        <?php } ?>
    </td>
    <td class="text-center">Rp. <?= number_format($total_real) ?></td>
</tr>