<!--<h1>--><?php //echo lang('login_heading');?><!--</h1>-->
<!--<p>--><?php //echo lang('login_subheading');?><!--</p>-->
<!---->
<!--<div id="infoMessage">--><?php //echo $message;?><!--</div>-->
<!---->
<?php //echo form_open("auth/login");?>
<!---->
<!--  <p>-->
<!--    --><?php //echo lang('login_identity_label', 'identity');?>
<!--    --><?php //echo form_input($identity);?>
<!--  </p>-->
<!---->
<!--  <p>-->
<!--    --><?php //echo lang('login_password_label', 'password');?>
<!--    --><?php //echo form_input($password);?>
<!--  </p>-->
<!---->
<!--  <p>-->
<!--    --><?php //echo lang('login_remember_label', 'remember');?>
<!--    --><?php //echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
<!--  </p>-->
<!---->
<!---->
<!--  <p>--><?php //echo form_submit('submit', lang('login_submit_btn'));?><!--</p>-->
<!---->
<?php //echo form_close();?>
<!---->
<!--<p><a href="forgot_password">--><?php //echo lang('login_forgot_password');?><!--</a></p>-->

<!doctype html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin - Login</title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="<?= base_url() ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/themify-icons.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/flag-icon.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/cs-skin-elastic.css">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/scss/style.css">

    <!--    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>-->

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->

</head>
<body class="bg-dark">


<div class="sufee-login d-flex align-content-center flex-wrap">
    <div class="container">
        <div class="login-content">
            <div class="login-logo">
                <a href="<?= site_url('auth/login') ?>">
                    <!--                    <img class="align-content" src="-->
                    <? //= base_url() ?><!--images/logo.png" alt="">-->
                    <h2 class="align-content text-light"><strong class="text-success">Login</strong> Admin</h2>
                </a>
            </div>
            <div class="login-form">
                <?php if (!empty($message)): ?>
                    <div class="alert  alert-danger alert-dismissible fade show" role="alert">
                        <span class="badge badge-pill badge-success">Gagal</span> <?= $message ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                <?php endif; ?>
                <?php
                $redirect = "";
                if (isset($_GET['redirect_to'])) $redirect = $_GET['redirect_to'];
                ?>
                <?php echo form_open("auth/login"); ?>
                <?php if (!empty($redirect)){
                    echo form_hidden('redirect_to', $redirect);
                } ?>
                <div class="form-group">
                    <label>Email/Username</label>
                    <input type="text" class="form-control" name="identity" id="identity" placeholder="Email/Username">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                </div>
                <div class="checkbox">
                    <label>
                        <input name="remember" value="1" id="remember" type="checkbox"> Ingat saya
                    </label>
                    <!--                        <label class="pull-right">-->
                    <!--                            <a href="#">Forgotten Password?</a>-->
                    <!--                        </label>-->
                </div>
                <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Sign in</button>

                <div class="register-link m-t-15 text-center">
                    <p>Tidak punya akun ? <a href="#"> Silahkan hubungi Administrator</a></p>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>


<script src="<?= base_url() ?>assets/js/vendor/jquery-2.1.4.min.js"></script>
<script src="<?= base_url() ?>assets/js/popper.min.js"></script>
<script src="<?= base_url() ?>assets/js/plugins.js"></script>
<script src="<?= base_url() ?>assets/js/main.js"></script>


</body>
</html>
