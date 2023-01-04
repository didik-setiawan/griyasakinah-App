<?php date_default_timezone_set('Asia/Jakarta'); ?>
<table class="table table-bordered">
    <thead>
        <tr class="bg-dark text-light">
            <th>#</th>
            <th>Tanggal</th>
            <th>Jumlah</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if($history){ ?>
        <?php $i = 1; foreach($history as $h){ ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= $h->tgl_bayar ?></td>
            <td>Rp. <?= number_format($h->jumlah) ?></td>
            <td>

                <?php if($h->status == 0){ ?>
                    <span class="badge badge-danger">Di Tolak</span>
                <?php } else if($h->status == 1){ ?>
                    <span class="badge badge-warning">Menunggu Konfirmasi Accounting</span>
                <?php } else if($h->status == 2){ ?>
                    <span class="badge badge-success">Menunggu Konfirmasi Super Admin</span>
                <?php } else if($h->status == 3){ ?>
                    <span class="badge badge-primary">Approved</span>
                <?php } ?>

            </td>
        </tr>
        <?php } ?>
        <tr>
            <th colspan="2">Total</th>
            <th colspan="2">Rp. <?= number_format($total) ?></th>
        </tr>
        <?php } else { ?>
            <tr>
                <td class="text-center" colspan="3">No data result</td>
            </tr>
        <?php } ?>
    </tbody>
</table>