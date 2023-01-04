<?php
if (HakAkses(18)->create == 1) {
    $statusC = NULL;
    $statusC1 = 'data-card-widget="collapse"';
} else {
    $statusC = 'disabled';
    $statusC1 = NULL;
}
if (HakAkses(18)->update == 1) {
    $statusU = NULL;
} else {
    $statusU = 'disabled';
}
if (HakAkses(18)->delete == 1) {
    $statusD = NULL;
} else {
    $statusD = 'disabled';
}
$profile = $this->master_model->getProfile(1)->row();

?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="text-uppercase">Setup Web Profile</h1>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-10">
                <form enctype="multipart/form-data" id="update_profile" role="form" method="POST">
                    <div class="card card-dark">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="card-title">SETUP</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body style=" display: block;">
                            <div class="row">
                                <div class="form-group col-sm-4 text-bold">
                                    Web Title :
                                </div>
                                <div class="form-group col-sm-8">
                                    <input type="text" class="form-control" value="<?= $profile->judul_web ?>" name="judul_web" id="judul_web">
                                    <small class="text-primary font-italic">* max 17 karakter, termasuk spasi</small>
                                </div>
                                <div class="form-group col-sm-4 text-bold">
                                    Nama Perusahaan/Lembaga :
                                </div>
                                <div class="form-group col-sm-8">
                                    <input type="text" class="form-control" value="<?= $profile->nama_lembaga ?>" name="nama_lembaga" id="nama_lembaga">
                                </div>
                                <div class="form-group col-sm-4 text-bold">
                                    Alamat :
                                </div>
                                <div class="form-group col-sm-8">
                                    <textarea name="alamat" id="alamat" class="form-control"><?= $profile->alamat ?></textarea>
                                </div>
                                <div class="form-group col-sm-4 text-bold">
                                    No Telp Kantor :
                                </div>
                                <div class="form-group col-sm-8">
                                    <input type="text" class="form-control" value="<?= $profile->telp ?>" name="telp" id="telp">
                                </div>
                                <div class="form-group col-sm-4 text-bold">
                                    Bidang Usaha :
                                </div>
                                <div class="form-group col-sm-8">
                                    <input type="text" class="form-control" value="<?= $profile->bidang ?>" name="bidang" id="bidang">
                                </div>
                                <div class="form-group col-sm-4 text-bold">
                                    Contact Person :
                                </div>
                                <div class="form-group col-sm-8">
                                    <input type="text" class="form-control" value="<?= $profile->contact_person ?>" name="contact_person" id="contact_person">
                                </div>
                                <div class="form-group col-sm-4 text-bold">
                                    No HP :
                                </div>
                                <div class="form-group col-sm-8">
                                    <input type="text" class="form-control" value="<?= $profile->hp ?>" name="hp" id="hp">
                                </div>
                                <div class="form-group col-sm-4 text-bold">
                                    Logo : <br>
                                </div>
                                <div class="form-group col-sm-8">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <label class="custom-file-label text-gray disabled">Update Logo</label>
                                            <input type="file" class="custom-file-input" name="gambar" id="gambar">
                                        </div>
                                    </div>
                                    <small class="text-info font-italic">* file gambar wajib <b>JPG</b> dengan ukuran square 1:1 (480 x 480 pixel)</small>
                                </div>
                                <div class="form-group col-sm-4">
                                </div>
                                <div class="form-group col-sm-4">
                                    <img class="img-thumbnail" src="<?= site_url('uploads/img/' . $profile->logo) ?>" alt="<?= $profile->logo ?>">
                                </div>
                                <div class="form-group col-sm-4">
                                    <input type="hidden" id="updateProfile" name="updateProfile">
                                    <input type="hidden" id="idProfile" name="idProfile" value="<?=$profile->id?>">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <button class="btn btn-primary btn-sm" type="submit">
                                        <span style="display: none;" id="sniped" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        <i class="fa fa-save"></i> Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->