<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h5>Detail Progres Pembangunan</h5>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

            <div class="card">
                <div class="card-header bg-dark">
                    <a href="<?= site_url('proyek/progres'); ?>" class="btn btn-sm btn-warning"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>
                <div class="card-body">
                    <button class="btn btn-sm btn-success mb-3 <?php access(); ?>" id="add-data" data-toggle="modal" data-target="#exampleModal" data-id="<?=  $this->uri->segment(3); ?>" data-blok="<?= $this->uri->segment(4); ?>"><i class="fa fa-plus"></i> Tambah</button>

                    <?php if(isset($data_mandor)){ ?>
                      <button class="btn btn-sm btn-primary mb-3 showMandor" data-proyek="<?= $upah_id ?>" data-blok="<?= $blok_id ?>"><i class="fa fa-search"></i> Data Mandor</button>
                    <?php } else { ?>
                      <button class="btn btn-sm btn-primary mb-3 addMandor"><i class="fa fa-plus"></i> Tambah Mandor</button>
                    <?php } ?>



                    <table class="table table-bordered mt-3" id="tableDetailProgres">
                        <thead>
                            <tr class="bg-dark text-light">
                                <th>Minggu ke</th>
                                <th>Tanggal</th>
                                <th>Persentase</th>
                                <th>Jumlah</th>
                                <th>Foto</th>
                                <th>Status</th>
                                <th>Status Trasfer Dana</th>
                                <th><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            
                            if(empty($detail)){
                              $sisa = 0;
                              $terbayar = 0;
                              $harga_kontrak = 0;
                            } else {

                            

                            $i=1; 
                            $terbayar = 0;
                            foreach($detail as $d){ 
                                if($d->status == 3){
                                  $terbayar += $d->total;
                                }
                            $sisa = $d->harga_kontrak - $terbayar;
                            $harga_kontrak = $d->harga_kontrak;
                            $id_progres = $d->id_progres;
                            $cicil = $this->db->get_where('cicil_progres',['id_progres' => $id_progres])->result();
                            

                            ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $d->tanggal ?></td>
                                <td><?= $d->progres ?>%</td>
                                <td>Rp. <?= number_format($d->total) ?></td>
                                <td>
                                    <img src="<?= base_url('assets/upload/progres/') . $d->foto; ?>" alt="img" width="100px" class="img-progres" data-img="<?= $d->foto ?>" style="cursor: pointer;">
                                </td>
                                <td class="text-center">
                                        <?php if($d->status == 1){ ?>
                                            <span class="badge badge-danger">Ditolak Accounting</span>
                                        <?php } else if($d->status == 2){ ?>
                                            <span class="badge badge-warning">Menunggu Persetujuan Accounting</span>
                                        <?php } else if($d->status == 3){ ?>
                                            <span class="badge badge-success">Approved</span>
                                        
                                        <?php } ?>
                                </td>
                                <td>
                                  <?php if(isset($cicil)){
                                    $tercicil = 0;
                                    foreach($cicil  as $c){
                                      if($c->status == 2){
                                        $tercicil += $c->jumlah;
                                      }
                                    }
                                    $sisa_cicil = $d->total - $tercicil;
                                    if($sisa_cicil == 0){
                                      $lunas = 'lunas';
                                    } else {
                                      $lunas = 'Belum Lunas';
                                    }
                                    ?>

<span class="badge badge-secondary"><?= $lunas ?></span> <br>
<small class="text-success">(Terbayar : Rp. <?= number_format($tercicil) ?>)</small> <br>
<small class="text-danger">(Sisa : Rp. <?= number_format($sisa_cicil) ?>)</small>


                                  <?php } else { ?>
                                  <?php } ?>
                                </td>
                                <td>
                                        <?php if($d->status == 1){ ?>
                                          <a href="<?= site_url('proyek/del_progres/') . $d->id_progres; ?>" class="btn btn-sm btn-danger btn-delete <?php access(); ?>"><i class="fa fa-trash"></i></a>
                                          <!-- <button class="btn btn-sm btn-primary btn-edit <?php access(); ?>" data-id="<?= $d->id_progres ?>"><i class="fa fa-edit"></i></button> -->
                                        <?php } ?>
                                </td>
                            </tr>
                            <?php } }?>
                        </tbody>
                        <tfoot>
                            <tr class="bg-dark text-light">
                                <th colspan="6">Harga Kontrak</th>
                                <th colspan="2">Rp. <?= number_format($harga_kontrak) ?></th>
                            </tr>
                            <tr class="bg-dark text-light">
                                <th colspan="6">Total Di Setujui</th>
                                <th colspan="2">Rp. <?= number_format($terbayar) ?></th>
                            </tr>
                            <tr class="bg-dark text-light">
                                <th colspan="6">Sisa</th>
                                <th colspan="2">Rp. <?= number_format($sisa) ?></th>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>

</div>
</div>
</div>
</section>




<!-- Modal detail -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post" id="formPersentase">
      <div class="modal-body">
        
        <input type="hidden" name="id_upah" id="id_upah">
        <input type="hidden" name="id_blok" id="id_blok">
        <input type="hidden" name="id_progres" id="id_progres">

        <div class="form-group">
            <label>Persentase (%)</label>
            <input type="number" name="persentase" id="persentase" class="form-control">
            <small class="text-danger" id="persent_err"></small>
            <small class="text-danger" id="persent_err2"></small>
        </div>

        <div class="form-group">
            <label>Jumlah (Rp)</label>
            <input type="text" name="v_jumlah" id="v_jumlah" class="form-control">
            <input type="text" hidden name="jumlah" id="jumlah" class="form-control">
            <small class="text-danger" id="jml_err"></small>
        </div>

        <div class="form-group">
            <label>Foto</label>
            <input type="file" name="foto" id="foto" class="form-control">
            <small class="text-danger" id="img_err"></small>
        </div>


        <div class="foto-progres-edit d-none">
            <img src="" alt="progres-pembangunan" id="bukti-progres" width="100%">
        </div> 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modelImageProgres" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-light">
        <h5 class="modal-title-1" id="exampleModalLabel">Foto Progres</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <img src="" id="foto-progres" alt="foto-progres" width="100%">

      </div>
     
    </div>
  </div>
</div>

                    <!-- Modal -->
<div class="modal fade" id="showMandor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel">Data Mandor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body showMandorModal">
                
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addMandor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-secondary text-light">
        <h5 class="modal-title mandorTitle" id="exampleModalLabel">Tambah Mandor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" id="formMandor" method="post">
      <div class="modal-body">
            <input type="hidden" name="id_mandor" id="id_mandor">
            <input type="hidden" name="id_proyek" id="id_proyek" value="<?= $upah_id ?>">
            <input type="hidden" name="id_kavling" id="id_kavling" value="<?= $blok_id ?>">
            <div class="form-group">
              <label>Pilih Mandor</label>
              <select name="mandor" id="mandor" class="form-control" required>
                <option value="">--Pilih--</option>
                <?php foreach($mandor as $m){ ?>
                  <option value="<?= $m->id_mandor ?>"><?= $m->nama_mandor ?></option>
                <?php } ?>
              </select>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

