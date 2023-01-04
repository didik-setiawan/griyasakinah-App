<?php
    
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="text-uppercase">Dokumentasi</h1>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4 form-group text-center">
                API Key : <span class="text-bold text-danger"><?=apiKEY()?></span>
            </div>
            <div class="col-sm-5 form-group text-center">
                Profile Lembaga : <span class="text-bold text-primary"><?=apiKEYProfile()?></span>
            </div>
            <div class="col-sm-3 form-group text-center">
                Status : <div class="badge" id="statusKey"></div>
            </div>
            <div class="col-sm-12 form-group" id="apiDokumentasi">
            </div>
        </div>
    </div>
</section>
<!-- /.content -->