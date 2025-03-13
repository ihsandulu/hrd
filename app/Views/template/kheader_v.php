<?php
$this->session = \Config\Services::session();
$this->request = \Config\Services::request();

use Config\Database;

$this->db = Database::connect("default");
$this->akunting = Database::connect("akunting");
if ($this->session->get('user_id') == "") {
    $this->session->setFlashdata("message", "Selamat Datang !");
    header('Location:' . base_url('login?message=Silahkan Login !'));
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>Costing</title>

    <link href="css/lib/chartist/chartist.min.css" rel="stylesheet">
    <link href="css/lib/owl.carousel.min.css" rel="stylesheet" />
    <link href="css/lib/owl.theme.default.min.css" rel="stylesheet" />
    <!-- Bootstrap Core CSS -->
    <link href="css/lib/bootstrap/bootstrap.min.4.5.2.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
    <!--[if lt IE 9]>
    <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


    <!-- 
    <script src="js/lib/jquery/jquery.min.js"></script>
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>-->


    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <link href="css/lib/toastr/toastr.min.css" rel="stylesheet">
    <script src="js/lib/toastr/toastr.min.js"></script>
    <script src="js/lib/toastr/toastr.init.js"></script>


    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>

    <script src="js/lib/datamap/d3.min.js"></script>
    <script src="js/lib/datamap/topojson.js"></script>
    <script src="js/lib/datamap/datamaps.world.min.js"></script>
    <script src="js/lib/datamap/datamap-init.js"></script>

    <script src="js/lib/weather/jquery.simpleWeather.min.js"></script>
    <script src="js/lib/weather/weather-init.js"></script>
    <script src="js/lib/owl-carousel/owl.carousel.min.js"></script>
    <script src="js/lib/owl-carousel/owl.carousel-init.js"></script>

    <script src="js/lib/chartist/chartist.min.js"></script>
    <script src="js/lib/chartist/chartist-plugin-tooltip.min.js"></script>
    <script src="js/lib/chartist/chartist-init.js"></script>




    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>

    <!--Fungsi Pemisah Ribuan -->
    <script src="js/pemisah_ribuan.js"></script>

    <style>
        .toast {
            min-width: 300px;
            position: fixed;
            bottom: 50px;
            right: 50px;
            z-index: 1000000000 !important;
            display: none;
        }

        .toast-header {
            background-color: aquamarine;
        }

        .toast-body {
            min-height: 100px;
        }

        .border {
            border: black solid 1px !important;
        }

        th,
        td {
            text-align: center;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }

        td {
            font-size: 14px;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            color: black !important;
        }

        .btn-action {
            padding: 0px;
            margin: 2px;
            display: inline;
        }

        .bold {
            font-weight: bold;
        }

        .green {
            color: olive;
        }
        .hidebar{
            height:inherit;
            overflow: auto;
        }

       /* Hide scrollbar for Chrome, Safari and Opera */
        .hidebar::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .hidebar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
    

</head>

<body class="fix-header fix-sidebar">
    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <div class="container-fluid">