<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/adminlte3/dist/css/adminlte.min.css') ?>">
    <title>No Access</title>
</head>
<body>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6" style="margin-top: 150px">
                <div class="text-center">
                    <img src="<?= base_url('assets/img/pray.png'); ?>" alt="pray" width="100px">
                </div>
                <h5 class="text-center mt-4 mb-4">Maaf, Akun anda tidak memiliki akses ke perumahan manapun</h5>
                <div class="text-center">
                    <a href="<?= site_url('login/logout'); ?>" class="btn btn-outline-success">Back to Login</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>