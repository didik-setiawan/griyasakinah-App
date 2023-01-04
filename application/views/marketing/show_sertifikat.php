<?php if(empty($data)){ ?>
    <p class="text-center">No data result</p>
<?php } else { ?>
    <?php foreach($data as $d){ ?>
    <table class="table table-bordered mb-3">
        <tr>
            <td colspan="2"><img src="<?= base_url('assets/surat/sertifikat/') . $d->file ?>" width="100%" alt="sertifikat"></td>
        </tr>
        <tr>
            <td>Di Upload pada <?php $date = date_create($d->tgl_upload); echo date_format($date,'d F Y'); ?></td>
            <td><a href="<?= site_url('marketing/delete_sertifikat/') . $d->id_sertifikat ?>" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Hapus</a></td>
        </tr>
    </table>
    <?php } ?>
<?php } ?>