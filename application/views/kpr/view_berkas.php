<table class="table table-bordered">
    <thead>
        <tr class="bg-secondary text-light">
            <th>Keterangan</th>
            <th>Berkas</th>
            <th><i class="fa fa-cogs"></i></th>
        </tr>
    </thead>
    <tbody>
        <?php if(empty($berkas)){ ?>
            <td colspan="3" class="text-center">No data result</td>
        <?php } else { ?>
            <?php foreach ($berkas as $b) { ?>
            <tr>
                <td><?= $b->keterangan ?></td>
                <td class="text-center"><img src="<?= base_url('assets/berkas/') . $b->file; ?>" width="20%"></td>
                <td>
                    <a href="<?= site_url('kpr/del_berkas/') . $b->id_berkas; ?>" class="btn btn-xs btn-danger <?php access(); ?>"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            <?php } ?>
        <?php } ?>
    </tbody>
</table>