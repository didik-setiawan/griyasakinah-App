<?php $group = $this->session->userdata('group_id'); if($konsumen->status_fee_marketing == 0){ ?>
<p class="text-center">No data result</p>
<?php } else { ?>
<table class="table table-bordered">
    <tr>
        <td>Status</td>
        <td>
            <?php if($konsumen->status_fee_marketing == 1){ ?>
                Menunggu Konfirmasi Accounting
            <?php } else if($konsumen->status_fee_marketing == 2){ ?>
                Approved
            <?php } else if($konsumen->status_fee_marketing == 3){ ?>
                Selesai
            <?php } else if($konsumen->status_fee_marketing == 4){ ?>
                Di Tolak Super Admin
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td>Nominal</td>
        <td>Rp. <?= number_format($konsumen->nominal_fee_marketing); ?></td>
    </tr>
    <tr>
        <td>Foto Bukti</td>
        <td>
            <img src="<?= base_url('assets/upload/fee-marketing/' . $konsumen->img_fee_marketing); ?>" alt="fee marketing" class="img-thumbnail">
        </td>
    </tr>
</table>

<div class="row">   
    <button type="button" class="btn btn-secondary btn-sm mr-3" data-dismiss="modal">Close</button>
    <?php if($group == 3){ ?>
        <?php if($konsumen->status_fee_marketing == 1){ ?>
         <a href="<?= site_url('accounting/confirm_fee_marketing/') . $konsumen->id_marketing; ?>" class="btn btn-success btn-sm toCode"><i class="fa fa-check"></i> Konfirmasi Fee Marketing</a>
        <?php } else if($konsumen->status_fee_marketing== 4) { ?>
        <a href="<?= site_url('accounting/repeat_fee_marketing/') . $konsumen->id_marketing; ?>" class="btn btn-sm btn-warning repeatFee"><i class="fas fa-redo-alt"></i> Konfirmasi Ulang</a>
        <?php } ?>
    <?php } ?>
</div>
<?php } ?>
