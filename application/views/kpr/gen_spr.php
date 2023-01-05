<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPR</title>
        <style>
            body {
                padding: 15px 15px 15px 15px;
                margin: 10px 10px 10px 10px;
            }
            .ttd {
                display: block;
                margin-left: 65%;
            }
            .row {
                grid-row-start: auto;
            }
            .text-center {
                text-align: center;
            }
        </style>
</head>
<body>
    
<div class="content">
    <table style="width: 100%;">
        <tr>
            <td><img src="<?= base_url('assets/img/g1.png'); ?>"></td>
            <td style="text-align: center;">
                <h5>Surat Pemesanan Rumah</h5>
            <h3>Perumahan <?= $rumah->nama_perumahan ?></h3>
            <small><?= $rumah->alamat_perumahan ?></small>
            <p>No: <?= $konsumen->id_marketing ?>/SPR/<?= date('m'); ?>/<?= date('Y'); ?></p></td>
            <td><img src="<?= base_url('assets/img/') . $this->session->userdata('logo_perumahan'); ?>" width="70px" height="70px"></td>
        </tr>
    </table>
    <hr>
    Saya yang bertanda tangan di bawah ini :
    <table style="width: 100%;">
        <tr>
            <td>Nama  </td>
            <td>: <?= $konsumen->nama_konsumen ?></td>
            <td>No. Hp </td>
            <td>: <?= $konsumen->no_hp ?></td>
        </tr>
        <tr>
            <td>TTL </td>
            <td>: </td>
            <td>Pekerjaan </td>
            <td>: <?= $konsumen->pekerjaan ?></td>
        </tr>
        <tr>
            <td>NIK  </td>
            <td>: <?= $konsumen->nik ?></td>
            <td>Tempat Kerja </td>
            <td>: <?= $konsumen->tempat_kerja ?></td>
        </tr>
        <tr>
            <td>Alamat </td>
            <td>: <?= $konsumen->alamat ?></td>
            <td>Gaji </td>
            <td>: Rp. <?= number_format($konsumen->gaji) ?></td>
        </tr>    
    </table>
    <br>
    Dengan ini menyatakan memesan 1 (satu) unit rumah yang terletak di Perumahan <?= $rumah->nama_perumahan ?>
    <table style="width: 100%;">
        <tr>
            <td>Type </td>
            <td>: <?= $rumah->tipe ?></td>
            <td>Cluster </td>
            <td>: <?php if($status_perum == 0){ echo "-";} else if($status_perum == 1){ echo $rumah->nama_cluster;} ?></td>
        </tr>
        <tr>
            <td>LB </td>
            <td>: <?= $rumah->lb ?> m<sup>2</sup></td>
            <td>Blok </td>
            <td>: <?= $rumah->blok ?></td>
        </tr>
        <tr>
            <td>LT </td>
            <td>: <?= $rumah->lt ?> m<sup>2</sup></td>
            <td>Nomor </td>
            <td>: <?= $rumah->no_rumah ?></td>
        </tr>
    </table>
    <br>
    Dengan rincian harga sebagai berikut :
    <table style="width: 100%;">
        <tr>
            <td>Harga pengajuan KPR </td>
            <td>: Rp. <?= number_format($kpr) ?></td>
        </tr>

        <tr>
            <td>Uang Muka (Pajak&Realisasi)	</td>
            <td>: Rp. <?php
                if(isset($uang_muka)){
                    number_format($uang_muka->jml_um);
                } else {
                    echo "0";
                }
            ?></td>
        </tr>

        <tr>
            <td>Perkiraan Angsuran (.....) tahun </td>
            <td>: </td>
        </tr>
       
        <tr>
            <td>Fasilitas/Bonus </td>
            <td>: </td>
        </tr>
    </table>
    <br>
    Dan perincian cara serta pembayaran sebagai berikut :

            <ul>
                <li>
                    Tanda Jadi jumlah Rp. <?= number_format($rumah->tanda_jadi); ?> tanggal pembayaran <?= $rumah->tgl_tanda_jadi ?>
                </li>
                <?php $i = 1; foreach($um as $u){ ?>
                <li>
                    Angsuran Uang Muka ke <?=$i++?> : Rp. <?= number_format($u->cicilan_angsuran); ?> Paling lambat dibayar tanggal <?= $u->jatuh_tempo; ?>
                </li>
                <?php } ?>
                <?php $i = 1; foreach($tjl as $t){ ?>
                    <li>
                        Angsuran Tanda Jadi Lokasi ke <?=$i++?> : Rp. <?= number_format($t->cicilan_angsuran); ?> Paling lambat dibayar tanggal <?= $t->jatuh_tempo; ?>
                    </li>
                <?php } ?>
                <?php $i=1; foreach($kt as $k){ ?>
                    <li>
                    Angsuran kelebihan Tanah ke <?=$i++?> : Rp. <?= number_format($k->cicilan_angsuran); ?> Paling lambat dibayar tanggal <?= $k->jatuh_tempo; ?>
                    </li>
                <?php } ?>


                <?php if($transaksi == 1){ ?>

                    <?php $i=1; foreach($pak as $p){ ?>
                        <li>
                        Angsuran PAK ke <?=$i++?> : Rp. <?= number_format($p->cicilan_angsuran); ?> Paling lambat dibayar tanggal <?= $p->jatuh_tempo; ?>
                        </li>
                    <?php } ?>

                    <?php $i=1; foreach($angsuran as $ang){ ?>
                        <li>
                        Angsuran Bank ke <?=$i++?> : Rp. <?= number_format($ang->cicilan_angsuran); ?> Paling lambat dibayar tanggal <?= $ang->jatuh_tempo; ?>
                        </li>
                    <?php } ?>

                    <?php $i=1; foreach($piutang as $pb){ ?>
                        <li>
                        Angsuran Piutang Bank ke <?=$i++?> : Rp. <?= number_format($pb->cicilan_angsuran); ?> Paling lambat dibayar tanggal <?= $pb->jatuh_tempo; ?>
                        </li>
                    <?php } ?>

                    <?php $i=1; foreach($lain as $l){ ?>
                        <li>
                            Angsuran Lain-lain ke <?=$i++?> : Rp. <?= number_format($l->cicilan_angsuran); ?> Paling lambat dibayar tanggal <?= $l->jatuh_tempo; ?>
                        </li>
                    <?php } ?>

                <?php } else if($transaksi == 2) { ?>

                    <?php $i=1; foreach($hk as $h){ ?>
                        <li>
                            Angsuran Harga Kesepakatan ke <?=$i++?> : Rp. <?= number_format($h->cicilan_angsuran); ?> Paling lambat dibayar tanggal <?= $h->jatuh_tempo; ?>
                        </li>
                    <?php } ?>

                <?php } ?>
            </ul>
    <br>
    Dengan ini saya menyatakan :
    <ol>
        <li>Apabila membatalkan pesanan, maka uang tanda jadi HANGUS dan uang muka yang sudah masuk, tidak dapat ditarik kembali / dibatalkan dengan alasan apapun.</li>
        <li>Apabila terjadi keterlambatan pembayaran uang muka dan pembayaran lainnya, maka pembeli dikenakan denda 0,5% perharinya.</li>
        <li>Jika terjadi penurunan plafon KPR, maka pihak pembeli bersedia menambah uang muka.</li>
        <li>Jika dalam waktu 14 hari pihak pembeli tidak melengkapi berkas yang dibutuhkan maka pihak Developer dapat memindah lokasi kavling tanpa pemberitahuan kepada pihak pembeli.</li>
        <li>Pembangunan bonus akan dilakukan ketika semua tangguangan dilunasi/ diselesaikan</li>
    </ol>

    <div class="ttd" style="text-align: center;">
        <?= $rumah->kabupaten ?> , <?php date_default_timezone_set('Asia/Jakarta'); echo date('d M Y'); ?>
    </div>
    <p style="text-align: center;">Di Setujui Oleh : </p>
    <table style="width: 100%;">
        <tr>
            <td style="width: 70%;">
                Pembeli
                <br><br>
                    <br>
                <br><br>
                <p class="text-center"><?= $konsumen->nama_konsumen ?></p>
            </td>
        
            <td>
                PT. Tunggal GriyaSakinah <br>
                Marketing/Admin
                <br><br><br><br>
                <p class="text-center"><?= $admin ?></p>
            </td>
        </tr>
    </table>

</div>
</body>
</html>