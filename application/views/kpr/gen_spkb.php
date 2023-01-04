<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPKB</title>
        <style>
            body {
                padding: 15px 15px 15px 15px;
                margin: 10px 10px 10px 10px;
            }
            .ttd {
                display: block;
                margin-left: 60%;
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
            <h5>Surat Pembatalan Kavling dan Bangunan</h5>
            <h3>Perumahan <?= $rumah->nama_perumahan ?></h3>
            <small><?= $rumah->alamat_perumahan ?></small>
            <p>No: <?= $konsumen->id_marketing ?>/SPKB/<?= date('m'); ?>/<?= date('Y'); ?></p></td>
            <td><img src="<?= base_url('assets/img/') . $this->session->userdata('logo_perumahan'); ?>" width="70px" height="70px"></td>
        </tr>
    </table>
    <hr>

    Yang bertandatangan dibawah ini :
        
            <table style="width: 100%;">
                <tr>
                    <td>Nama </td>
                    <td>: <?= $konsumen->nama_konsumen ?></td>
                </tr>
                <tr>
                    <td>Alamat </td>
                    <td>: <?= $konsumen->alamat ?></td>
                </tr>
                <tr>
                    <td>Nomor KTP </td>
                    <td>: <?= $konsumen->nik ?></td>
                </tr>
            </table>

        <br>
        Adalah benar telah memesan 1 (satu) unit rumah berikut :
      
        <table style="width: 100%;">
            <tr>
                <td style="width: 200px;">Cluster</td>
                <td>: <?php if($status_perum == 0){ echo "-"; } else if($status_perum == 1){ echo $rumah->nama_cluster; } ?></td>
            </tr>
            <tr>
                <td>Blok</td>
                <td>: <?= $rumah->blok ?></td>
            </tr>
            <tr>
                <td>Nomor Rumah</td>
                <td>: <?= $rumah->no_rumah ?></td>
            </tr>
            <tr>
                <td>Type</td>
                <td>: <?= $rumah->tipe ?></td>
            </tr>
        </table>
        <br>
        <p>   
            Dengan ini menyatakan pembatalan atau tidak melanjutkan pembelian 1 unit rumah di Perumahan <?= $rumah->nama_perumahan ?>, sehingga hak atas tanah saya kembalikan kepada PT. Tunggal Griya Sakinah selaku pihak developer dan membebaskan pihak PT. Tunggal Griya Sakinah dari segala tuntutan pidana maupun perdata dari pihak manapun. 
        </p>
        <p>Adapun jumlah pengembalian dana sejumlah :</p>
      

        <table style="width: 100%;">
        <?php if($transaksi == 1){ ?>

            <?php if(isset($tj)){ ?>
                <tr>
                    <td>#</td>
                    <td>Tanda Jadi</td>
                    <td>Rp. <?= number_format($tj); ?></td>
                </tr>
            <?php }  ?>

            <?php if(isset($tjl)){ ?>
                <tr>
                    <td>#</td>
                    <td>Tanda Jadi Lokasi</td>
                    <td>Rp. <?= number_format($tjl); ?></td>
                </tr>
            <?php }  ?>

            <?php if(isset($um)){ ?>
                <tr>
                    <td>#</td>
                    <td>Uang Muka</td>
                    <td>Rp. <?= number_format($um); ?></td>
                </tr>
            <?php } ?>

            <?php if(isset($kt)){ ?>
                <tr>
                    <td>#</td>
                    <td>Kelebihan Tanah</td>
                    <td>Rp. <?= number_format($kt); ?></td>
                </tr>
            <?php } ?>

            <?php if(isset($pak)){ ?>
                <tr>
                    <td>#</td>
                    <td>PAK</td>
                    <td>Rp. <?= number_format($pak); ?></td>
                </tr>
            <?php } ?>

            <?php if(isset($angsuran)){ ?>
                <tr>
                    <td>#</td>
                    <td>Angsuran Bank</td>
                    <td>Rp. <?= number_format($angsuran); ?></td>
                </tr>
            <?php } ?>

            <?php if(isset($piutang)){ ?>
                <tr>
                    <td>#</td>
                    <td>Piutang Bank</td>
                    <td>Rp. <?= number_format($piutang); ?></td>
                </tr>
            <?php } ?>

            <?php if(isset($lain)){ ?>
                <tr>
                    <td>#</td>
                    <td>Lain-lain</td>
                    <td>Rp. <?= number_format($lain); ?></td>
                </tr>
            <?php } ?>

        <?php } else if($transaksi == 2) { ?>

            <?php if(isset($tj_i)){ ?>
                <tr>
                    <td>#</td>
                    <td>Tanda Jadi</td>
                    <td>Rp. <?= number_format($tj_i); ?></td>
                </tr>
            <?php }  ?>

            <?php if(isset($hk_i)){ ?>
                <tr>
                    <td>#</td>
                    <td>Harga Kesepakatan</td>
                    <td>Rp. <?= number_format($hk_i); ?></td>
                </tr>
            <?php } ?>

            <?php if(isset($um_i)){ ?>
                <tr>
                    <td>#</td>
                    <td>Uang Muka</td>
                    <td>Rp. <?= number_format($um_i); ?></td>
                </tr>
            <?php } ?>

            <?php if(isset($kt_i)){ ?>
                <tr>
                    <td>#</td>
                    <td>Kelebihan Tanah</td>
                    <td>Rp. <?= number_format($kt_i); ?></td>
                </tr>
            <?php } ?>

            <?php if(isset($tjl_i)){ ?>
                <tr>
                    <td>#</td>
                    <td>Tanda Jadi Lokasi</td>
                    <td>Rp. <?= number_format($tjl_i); ?></td>
                </tr>
            <?php } ?>
        <?php } ?>
            <tr>
                <td colspan="2"><b>Jumah</b></td>
                <td><b>Rp. <?= number_format($jumlah) ?></b></td>
            </tr>
        </table>


        <p>Yang akan dilakukan pembayaran melalui transfer ke : </p>

        Nomor Rekening	: ..................................................
        <br>
        Nama Pemilik		: ..................................................
        <br>
        Bank			: ..................................................	
    <p>Pembayaran tersebut dapat dilakukan secara bertahap sesuai dengan ketentuan PT. Tunggal Griya Sakinah.</p>
    <p>Demikian surat pernyataan ini dibuat dan ditandatangani dengan sebenar-benarnya tanpa paksaan dari pihak manapun. </p>
    </div>

    <div class="ttd" style="text-align: center">
        .<?= $rumah->kabupaten ?>,<?php date_default_timezone_set('Asia/Jakarta'); echo date('d M Y'); ?>
        <!-- <br><br><br><br><br>
        <?= $admin; ?> -->
    </div>
    <br>
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
                Marketing
                <br><br><br><br>
                <p class="text-center"><?= $admin ?></p>
            </td>
        </tr>
    </table>

</div>

</body>
</html>