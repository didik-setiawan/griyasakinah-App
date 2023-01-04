<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Management Cluster</h1>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        
                        <button class="btn btn-outline-success btn-sm add-cluster mb-3 <?php access(); ?>" data-target="#modal-cluster" data-toggle="modal"><i class="fa fa-plus"></i> Tambah Cluster</button>

                        <table class="table table-bordered" id="clusterTable">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th>#</th>
                                    <th>Nama Perumahan</th>
                                    <th>Nama Cluster</th>
                                    <th><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach($cluster as $c){
                                 ?>
                                
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $c->nama_perumahan ?></td>
                                    <td><?= $c->nama_cluster ?></td>
                                    <td>
                                        <div class="<?php access(); ?>">
                                        <button class="btn btn-xs btn-primary edit-cluster" data-id="<?= $c->id_cluster ?>" data-target="#modal-cluster" data-toggle="modal"><i class="fa fa-edit"></i></button>
                                        <a href="<?= site_url('master/del_cluster/') . $c->id_cluster; ?>" class="btn btn-xs btn-danger del-cluster"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="msg-err" data-pesan="<?= $this->session->flashdata('err'); ?>"></div>
<div class="msg-scs" data-pesan="<?= $this->session->flashdata('scs'); ?>"></div>

<!-- Modal -->
<div class="modal fade" id="modal-cluster" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-light" id="exampleModalLabel"></h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
<form action="" method="post">
        <div class="modal-body">
               <div class="form-group">
                   <label>Nama Perumahan</label>
                   <select class="form-control" name="perum" id="perum" required>
                       <option value="">--Pilih perumahan--</option>
                       <?php foreach($perum as $p){ ?>
                        <option value="<?= $p->id_perumahan ?>"><?= $p->nama_perumahan ?></option>
                        <?php } ?>
                   </select>
               </div>
               <div class="form-group">
                   <label>Nama Cluster</label>
                   <input type="text" name="cluster" required class="form-control" id="cluster">
               </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>