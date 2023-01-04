<table class="table table-bordered">
    <thead>
        <tr class="bg-dark text-light">
            <th>Bukti SPKB</th>
            <th width="15px"><i class="fa fa-cogs"></i></th>
        </tr>
    </thead>
    <tbody>
        <?php if(empty($bukti_spkb)){ ?>
            <td colspan="2"><p class="text-center">No data result</p></td>
        <?php } else { ?>
            <?php foreach($bukti_spkb as $b){ ?>
            <tr>
                <td class="text-center">
                    <?php if($b->file_type == '.pdf'){ ?>
                        <object data="<?= base_url('assets/surat/spkb/') . $b->bukti_spkb; ?>" width="100%" height="1000px"></object>
                    <?php } else { ?>
                        <img src="<?= base_url('assets/surat/spkb/') . $b->bukti_spkb; ?>" width="20%">
                    <?php } ?>
                </td>
                <td><a href="<?= site_url('marketing/delete_bukti_spkb/') . $b->id_bukti_spkb; ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</a></td>
            </tr>
            <?php } ?>
        <?php } ?>
    </tbody>
</table>