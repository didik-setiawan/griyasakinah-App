<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/css/sb-admin-2.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/adminlte3/plugins/fontawesome-free/css/all.min.css'); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <title>Login Page</title>
    <style>
        body {
            /* background: #a8fff2; */
            background: linear-gradient(to left, #4105f5, #b103fc);
        }
        #pt-name{
            color: #000000;
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body>
    <div class="container">
    

        <div class="row justify-content-center mt-5">
            <div class="col-12 col-md-8 col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="<?= base_url('uploads/img/profile-64aa55cabb.jpg'); ?>" width="30%">
                            <h4 id="pt-name">PT. Tunggal Griya Sakinah</h4>
                        </div>
                        <hr>
                        <p class="text-center">Login Page</p>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="validatedInputGroupPrepend"><i class="fas fa-phone"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Phone number" aria-describedby="validatedInputGroupPrepend" required>
                        </div>
                        <div class="input-group mt-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="validatedInputGroupPrepend"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" class="form-control" placeholder="Password" aria-describedby="validatedInputGroupPrepend" required>
                        </div>

                        <div class="text-center mt-4">
                            <button class="btn btn-outline-primary" type="submit">Sign In</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        </div>
</body>
</html>