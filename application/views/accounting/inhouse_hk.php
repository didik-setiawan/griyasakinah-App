<?php $group = $this->session->userdata('group_id'); if(empty($data)){ ?>
    <i class="text-center">No Data Result</i>
<?php } else { 
    
    if($group == 3 || $group == 7){
        $action = '';
    } else {
        $action = 'disabled';
    }

?>
<table class="table table-bordered" id="theTable">
    <thead>
        <tr class="bg-dark text-light">
           
            <th>Angsuran</th>
            <th>Jumlah Pembayaran</th>
            <th>Jatuh Tempo</th>
            <th>keterangan</th>
            <th><i class="fa fa-cogs"></i></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; foreach($data as $d){
            
            $type = 'inhouse_hk';
            $id = $d->id_kesepakatan;
            
            if($d->status != 2){
                $this->master->count_denda_pembayaran_konsumen($type, $id);
            }

            $denda = $d->denda;
            $terbayar = $this->master->count_terbayar($type, $id);

            $total_bayar = $denda + $d->cicilan_angsuran - $terbayar;
        ?>
        <tr>
            
            <td><?= $i++ ?></td>
            <td><b>Rp. <?= number_format($total_bayar);  ?></b> <br>
                <small class="text-primary">(Jumlah Angsuran : Rp. <?= number_format($d->cicilan_angsuran); ?>)</small> <br>
                <small class="text-danger">(Denda : Rp. <?= number_format($denda); ?>)</small>
            </td>
            <td><?php $date = date_create($d->jatuh_tempo); echo date_format($date, 'd F Y'); ?></td>
            <td><?php if($total_bayar > 0){ ?>
                    <span class="badge badge-danger">Belum Lunas</span>
                <?php } else if($total_bayar == 0 || $total_bayar < 0) { ?>
                    <span class="badge badge-success">Lunas</span>
                <?php } ?>
            </td>
            <td>
                <?php if($d->status == 0){ ?>
                    <button <?= $action ?> class="btn btn-xs btn-success toCode" data-id="<?= $d->id_kesepakatan ?>" data-type="inhouse_hk"><i class="fa fa-check"></i></button>
                <?php } else if($d->status == 1 || $d->status == 2){ ?>
                    <button class="btn btn-xs btn-primary toBayar" data-id="<?= $d->id_kesepakatan ?>" data-type="inhouse_hk" data-sisa="<?= $total_bayar ?>"><i class="fa fa-plus"></i></button>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php } ?>
