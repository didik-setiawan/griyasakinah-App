<table class="table table-bordered">
    <thead>
        <tr class="bg-dark text-light">
            <th>Nama Mandor</th>
            <th>No Telp</th>
            <th>Data Rekening</th>
            <th><i class="fa fa-cogs"></i></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?= $mandor->nama_mandor ?></td>
            <td><?= $mandor->no_telp ?></td>
            <td> 
                <b><?= $mandor->nama_bank ?></b> <br>
                <span><?= $mandor->no_rekening ?></span> <br>
                <small class="text-primary"><?= $mandor->atas_nama ?></small>
            </td>
            <td>
                <button class="btn btn-sm btn-success editDataMandor" data-id="<?= $mandor->id_mandor_proyek ?>" data-mandor="<?= $mandor->id_mandor; ?>"><i class="fa fa-edit"></i></button>
                <button class="btn btn-sm btn-danger deleteDataMandor" data-id="<?= $mandor->id_mandor_proyek ?>"><i class="fa fa-trash "></i></button>
            </td>
        </tr>
    </tbody>
</table>