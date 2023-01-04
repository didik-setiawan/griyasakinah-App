<?php $i = 1; foreach($calon_konsumen as $c){ ?>
    <tr>
        <td><?= $i++; ?></td>
        <td><?= $c->nama_konsumen ?></td>
        <td><?= $c->no_hp ?></td>
        <td><?= $c->jk ?></td>
        <td>Calon Konsumen</td>
        <td>
            <button class="btn btn-xs btn-info" data-toggle="modal" data-target="#staticBackdrop" data-id="<?= $c->id_marketing ?>"><i class="fa fa-plus"></i></button>
        </td>
    </tr>
<?php } ?>