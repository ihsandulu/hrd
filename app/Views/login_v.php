<?php
$this->session = \Config\Services::session();
$this->request = \Config\Services::request();

use Config\Database;

$this->db = Database::connect("default");
$icon = "";
$nama = "";
$identity = $this->db->table("identity")->get();
foreach($identity->getResult() as $identity){
    $icon = $identity->identity_logo;
    $nama = $identity->identity_name;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/identity_logo/<?=$icon;?>" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link href="css/lib/toastr/toastr.min.css" rel="stylesheet">

    <!--===============================================================================================-->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script src="js/main.js"></script>
    <!--===============================================================================================-->

    <script src="js/lib/toastr/toastr.min.js"></script>
    <script src="js/lib/toastr/toastr.init.js"></script>

    <style>
        .toast {
            min-width: 300px;
            position: fixed;
            bottom: 50px;
            right: 50px;
            z-index: 1000000000 !important;
            display:none;
        }

        .toast-header {
            background-color: aquamarine;
        }

        .toast-body {
            min-height: 100px;
        }
        .container-login100 {
            background-image: url('images/sgibackground.png'); /* Gantilah 'nama_gambar.jpg' dengan nama dan path file gambar Anda */
            background-attachment: fixed;
            background-size: cover; /* Opsional: Sesuaikan dengan kebutuhan Anda, bisa diganti dengan 'contain' atau nilai lainnya */
            background-position: center; /* Opsional: Sesuaikan dengan kebutuhan Anda */
            background-repeat: no-repeat; /* Opsional: Sesuaikan dengan kebutuhan Anda */
            /* Penambahan properti warna latar belakang jika gambar tidak dapat dimuat atau sebagai cadangan */
            background-color: #f0f0f0; /* Gantilah dengan warna yang diinginkan */
            /* Tambahan properti untuk memberikan tekstur atau warna overlay di atas gambar */
            /* Misalnya: */
            /* background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('nama_gambar.jpg'); */
            /* Pengaturan warna dan transparansi dalam linear-gradient menentukan efek overlay */
        }
        .wrap-login100{opacity:0.9;}
        #logo{width:auto; height:150px; margin: 0px;}
        .gambarlogo{padding: 0px;}
        .login100-form-title{
            padding-top: 25px;
            padding-bottom:25px;
        }
    </style>
</head>

<body>


    <!--Toast-->
    <div class="toast" data-autohide="false">
        <div class="toast-header">
            <strong class="mr-auto text-primary">Alert</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
        </div>
        <div class="toast-body">
            asdfaf
        </div>
    </div>
    <div class="limiter">
        <div class="container-login100"> 
            <div class="wrap-login100">
                <form action="<?= base_url('login'); ?>" method="POST" class="login100-form validate-form p-l-55 p-r-55 p-t-178">
                    <span class="login100-form-title">
                        <div class="gambarlogo mb-3">
                            <img src="<?=base_url("images/identity_logo/".$icon);?>" id="logo"/>
                        </div> 
                        <small>.:: <i><?=$nama;?></i> ::.</small>
                    </span>

                    <div class="wrap-input100 validate-input m-b-16" data-validate="Please enter NIK">
                        <input autofocus class="input100" type="text" name="user_nik" placeholder="NIK">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-16" data-validate="Please enter password">
                        <input class="input100" type="password" name="password" placeholder="Password">
                        <span class="focus-input100"></span>
                    </div> 
                    
                    <!-- <div class="wrap-input100 validate-input" data-validate="Please enter your Store ID">
                        <input class="input100" type="number" name="storeid" placeholder="Store ID">
                        <span class="focus-input100"></span>
                    </div> -->

                    <!--
                    <div class="text-right p-t-13 p-b-23">
                        <span class="txt1">
                            Forgot
                        </span>

                        <a href="#" class="txt2">
                            user_nik / Password?
                        </a>
                    </div>
                    -->
                    <div class="flex-col-c my-40">&nbsp;</div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                            Sign in
                        </button>
                    </div>
                    <!--
					<div class="flex-col-c p-t-170 p-b-40">
						<span class="txt1 p-b-9">
							Don’t have an account?
						</span>

						<a href="#" class="txt3">
							Sign up now
						</a>
					</div>
                    -->
                    <div class="flex-col-c my-40">&nbsp;</div>
                </form>
            </div>
        </div>
    </div>

    <script>
        <?php
        $this->session = \Config\Services::session();
        ?>
        showmessage(3000);

        function showmessage(a) {
            //alert('<?= (isset($_GET['message'])) ? $_GET['message'] : $this->session->getFlashdata("message"); ?>');
            <?php
            if (isset($_GET['message'])) {
                $isipesan = $_GET['message'];
            } else {
                $isipesan = $this->session->getFlashdata("message");
            }
            ?>
            /* $('.toast-body').html('<?= $isipesan ?>');
            $('.toast').toast('show');
            if (a > 0) {
                setTimeout(function() {
                    $('.toast').toast('hide');
                }, a);
            } */

            toast('INFO >>>', '<?= $isipesan ?>');
        }

        <?php if ($this->session->getFlashdata("message") != "" || isset($_GET['message'])) { ?>
            showmessage(3000);
        <?php } ?>

        function toast(judul, isi) {
            toastr.warning(isi, judul, {
                "positionClass": "toast-bottom-right",
                timeOut: 5000,
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut",
                "tapToDismiss": false

            })
        }
    </script>



</body>

</html>