<?php
$group = $this->session->userdata('group_id');

if($group == 3 || $group == 7){
    $action = '';
} else {
    $action = 'disabled';
}

if(empty($data)){ ?>
    No data result
<?php } else { 
    $tanggal = date_create($data->tgl_tanda_jadi);    

    $type = 'bank_tj';
    $id = $data->id_transaksi_bank;

    $terbayar = $this->master->count_terbayar($type, $id);

    $total_bayar = $data->tanda_jadi - $terbayar;

?>

    <table class="table table-bordered">
        <thead class="bg-dark text-light">
            <tr>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th><i class="fa fa-cogs"></i></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= date_format($tanggal, 'd F Y') ?></td>
                <td>Rp. <?= number_format($data->tanda_jadi) ?></td>
                <td>
                    <?php if($data->status == 0){ ?>
                        <button <?= $action ?> class="btn btn-xs btn-success toCode" data-id="<?= $data->id_transaksi_bank ?>" data-type="bank_tj"><i class="fa fa-check"></i></button>
                    <?php } else if($data->status == 1 || $data->status == 2){ ?>
                        <button class="btn btn-xs btn-primary toBayar" data-sisa="<?= $total_bayar ?>" data-id="<?= $data->id_transaksi_bank ?>" data-type="bank_tj" ><i class="fa fa-plus"></i></button>
                    <?php } ?>
                </td>
            </tr>
        </tbody>
    </table>

<?php } ?>
