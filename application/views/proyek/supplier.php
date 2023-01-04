<script text="javascript">
    $('#sup-table').dataTable();
</script>

<table class="table table-bordered table-striped" id="sup-table">
<thead>
    <tr class="bg-dark text-light">
        <th>#</th>
        <th style="text-align: center;">Nama</th>
        <th style="text-align: center;">Alamat</th>
        <th style="text-align: center;">Nama Toko</th>
        <th style="text-align: center;">Kontak</th>
        <th style="text-align: center;">Harga Real</th>
        <!-- <th style="text-align: center;">
            <i class="fa fa-cogs"></i>
        </th> -->
    </tr>
</thead>
<tbody>
    <?php $i =1; foreach($logistik as $key => $row){ ?>
        <tr>
            <td><?= $i++ ?></td>
                <td style="text-align: center;"><?=$row->nama?></td>
                <td><?=$row->alamat?></td>
                <td style="text-align: center;"><?=$row->nama_toko?></td>
                <td style="text-align: center;"><?=$row->no_tlp?></td>
                <td style="text-align: right;">Rp <?=rupiah2($row->harga_real)?></td>
                <!-- <td class="text-center">
                <button type="button" data-toggle="tooltip" data-placement="left" title="Hapus" class="btn btn-danger btn-xs" id="del-sup" data-id="<?= $row->id_logistik_detail ?>"><i class="fa fa-trash"></i></button>
                </td> -->
        </tr>
    <?php } ?>
</tbody>
</table>


<?php $i =1; foreach($logistik as $k){ ?>
<div class="row">
    <div class="col-lg-6">
        <table class="table table-bordered">
            <tr class="bg-dark text-light">
                <th>Bukti Nota</th>
            </tr>
            <tr>
                <td class="text-center">
                    <?php if($k->nota){ ?>
                        <img src="<?= base_url('assets/berkas/') . $k->nota ?>" alt="nota" width="80%">
                    <?php } else { ?>
                        -
                    <?php } ?>
                </td>
            </tr>
        </table>
    </div>
    <div class="col-lg-6">
        <table class="table table-bordered">
            <tr class="bg-dark text-light">
                <th>Bukti Pembayaran</th>
            </tr>
            <tr>
                <td class="text-center">
                    <?php if($k->bukti_pembayaran){ ?>
                        <img src="<?= base_url('assets/bukti_pembayaran/') . $k->bukti_pembayaran ?>" alt="pembayaran" width="80%">
                    <?php } else { ?>
                        -
                    <?php } ?>
                </td>
            </tr>
        </table>
    </div>
</div>

<?php } ?>