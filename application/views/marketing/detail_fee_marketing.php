<?php
    $cicil = $this->db->get_where('cicil_fee_marketing',['id_marketing' => $marketing->id_marketing])->result();
    $total = $marketing->nominal_fee_marketing;
    $terbayar = 0;
    foreach($cicil as $c){
        if($c->status == 2){
            $terbayar += $c->jumlah;
        }
    }
    $sisa = $total - $terbayar;
    if($sisa == 0){
        $lunas = 'Lunas';
    } else {
        $lunas = 'Belum Lunas';
    }
?>
<table class="table table-bordered">
    <tr>
        <td>Nominal</td>
        <td>Rp. <?= number_format($marketing->nominal_fee_marketing); ?></td>
    </tr>
    <tr>
        <td>Status</td>
        <td>
            <?php if($marketing->status_fee_marketing == 1){ ?>
                Menunggu Konfirmasi
            <?php } else if($marketing->status_fee_marketing == 2){ ?>
                Approved
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td>Status Transfer Dana</td>
        <td><?=$lunas; ?></td>
    </tr>
    <tr>
        <td>Total Terbayar</td>
        <td>Rp. <?= number_format($terbayar); ?></td>
    </tr>
    <tr>
        <td>Sisa Pembayaran</td>
        <td>Rp. <?= number_format($sisa) ?></td>
    </tr>
    <tr>
        <td>Foto Bukti</td>
        <td>
            <img src="<?= base_url('assets/upload/fee-marketing/') . $marketing->img_fee_marketing; ?>" width="100%">
        </td>
    </tr>
    
</table>