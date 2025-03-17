<?php echo $this->include("template/header_v"); ?>
<style>
    .modal-content {
        background-color: transparent;
        /* Membuat latar belakang modal menjadi transparan */
        border: none;
    }

    .modal-body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 80vh;
        /* Mengatur tinggi modal menjadi 80% tinggi layar */
    }

    .modal-body .gambar {
        max-height: 100%;
        /* Membuat gambar tidak melebihi tinggi modal */
        width: auto;
        height: auto;
    }
</style>

<div class='container-fluid'>
    <div class='row'>
        <div class='col-12'>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <?php if (!isset($_GET['user_id']) && !isset($_POST['new']) && !isset($_POST['edit'])) {
                            $coltitle = "col-md-10";
                        } else {
                            $coltitle = "col-md-8";
                        } ?>
                        <div class="<?= $coltitle; ?>">
                            <h4 class="card-title"></h4>
                            <!-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6> -->
                        </div>

                        <?php if (!isset($_POST['new']) && !isset($_POST['edit']) && !isset($_GET['report'])) { ?>
                            <?php if (isset($_GET["user_id"])) { ?>
                                <form action="<?= base_url("user"); ?>" method="get" class="col-md-2">
                                    <h1 class="page-header col-md-12">
                                        <button class="btn btn-warning btn-block btn-lg" value="OK" style="">Back</button>
                                    </h1>
                                </form>
                            <?php } ?>
                            <?php
                            if (
                                (
                                    isset(session()->get("position_administrator")[0][0])
                                    && (
                                        session()->get("position_administrator") == "1"
                                        || session()->get("position_administrator") == "2"
                                    )
                                ) ||
                                (
                                    isset(session()->get("halaman")['50']['act_create'])
                                    && session()->get("halaman")['50']['act_create'] == "1"
                                )
                            ) { ?>
                                <form method="post" class="col-md-2">
                                    <h1 class="page-header col-md-12">
                                        <button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
                                        <input type="hidden" name="absen_id" />
                                    </h1>
                                </form>
                            <?php } ?>
                        <?php } ?>
                    </div>

                    <?php if (isset($_POST['new']) || isset($_POST['edit'])) { ?>
                        <div class="">
                            <?php if (isset($_POST['edit'])) {
                                $namabutton = 'name="change"';
                                $judul = "Update Absensi";
                            } else {
                                $namabutton = 'name="create"';
                                $judul = "Tambah Absensi";
                            } ?>
                            <div class="lead">
                                <h3><?= $judul; ?></h3>
                            </div>
                            <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="absen_type">Type:</label>
                                    <div class="col-sm-10">
                                        <select onchange="pilihtipe()" autofocus required class="form-control select" id="absen_type" name="absen_type">
                                            <option value="" <?= ($absen_type == "") ? "selected" : ""; ?>>Pilih Type</option>
                                            <option value="Masuk" <?= ($absen_type == "Masuk") ? "selected" : ""; ?>>Masuk</option>
                                            <option value="Keluar" <?= ($absen_type == "Keluar") ? "selected" : ""; ?>>Keluar</option>
                                            <option value="Sakit" <?= ($absen_type == "Sakit") ? "selected" : ""; ?>>Sakit</option>
                                            <option value="Izin" <?= ($absen_type == "Izin") ? "selected" : ""; ?>>Izin</option>
                                            <option value="Cuti" <?= ($absen_type == "Cuti") ? "selected" : ""; ?>>Cuti</option>
                                            <option value="Alpha" <?= ($absen_type == "Alpha") ? "selected" : ""; ?>>Alpha</option>
                                        </select>

                                    </div>
                                </div>
                                <script>
                                    function pilihtipeori() {
                                        var absen_type = $("#absen_type").val();
                                        if (absen_type == "Sakit") {
                                            $(".sakit").show();
                                        } else {
                                            $(".sakit").hide();
                                        }
                                        if (absen_type == "Cuti") {
                                            $(".cuti").show();
                                        } else {
                                            $(".cuti").hide();
                                        }
                                    }
                                    function pilihtipe() {
                                        var absen_type = $("#absen_type").val();
                                        if (absen_type == "Sakit") {
                                            $(".sakit").show();
                                        } else {
                                            $(".sakit").hide();
                                            $("#absen_skd").val(0);
                                        }
                                        if (absen_type == "Cuti") {
                                            $(".cuti").show();
                                        } else {
                                            $(".cuti").hide();
                                            $("#cuti_id").val(0);
                                        }
                                    }
                                    $(document).ready(function() {
                                        $(".sakit").hide();
                                        $(".cuti").hide();
                                        pilihtipeori();
                                    });
                                </script>

                                <div class="form-group sakit">
                                    <label class="control-label col-sm-2" for="absen_skd">SKD:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="absen_skd" name="absen_skd">
                                            <option value="0" <?= ($absen_skd == "0") ? "selected" : ""; ?>>Tidak</option>
                                            <option value="1" <?= ($absen_skd == "1") ? "selected" : ""; ?>>Ya</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group cuti">
                                    <label class="control-label col-sm-2" for="cuti_id">Cuti:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="cuti_id" name="cuti_id">
                                            <option value="0" <?= ($cuti_id == "0") ? "selected" : ""; ?>>Pilih Cuti</option>
                                            <?php $cuti=$this->db->table("cuti")->orderBy("cuti_name","ASC")->get(); ?>
                                            <?php foreach ($cuti->getResult() as $cuti) { ?>
                                                <option value="<?= $cuti->cuti_id; ?>" <?= ($cuti_id == $cuti->cuti_id) ? "selected" : ""; ?>><?= $cuti->cuti_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="absen_note">Keterangan:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="absen_note" name="absen_note" placeholder="" value="<?= $absen_note; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="absen_datetime">Date Time:</label>
                                    <div class="col-sm-10">
                                        <input onchange="rdate()" required type="datetime-local" class="form-control" id="absen_datetime" name="absen_datetime" placeholder="" value="<?= $absen_datetime; ?>">

                                        <input type="hidden" id="absen_date" name="absen_date" value="<?= $absen_date; ?>" />
                                        <input type="hidden" id="absen_time" name="absen_time" value="<?= $absen_time; ?>" />
                                        <script>
                                            function rdate() {
                                                let datetime = $("#absen_datetime").val();
                                                // Memisahkan tanggal dan waktu
                                                var parts = datetime.split(" ");
                                                var tanggal = parts[0];
                                                var waktu = parts[1];
                                                $("#absen_date").val(tanggal);
                                                $("#absen_time").val(waktu);
                                            }
                                        </script>
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <label class="control-label col-sm-2" for="absen_geo">Geolocation:</label>
                                    <div class="col-sm-10">
                                        <input required type="text"  class="form-control" id="absen_geo" name="absen_geo" placeholder="" value="<?= $absen_geo; ?>">
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="absen_tp">Name:</label>
                                    <div class="col-sm-10">
                                        <?php
                                        $user = $this->db
                                            ->table("user")
                                            ->join("departemen", "departemen.departemen_id=user.departemen_id", "left")
                                            ->orderBy("user.user_nama", "ASC")
                                            ->get();
                                        //echo $this->db->getLastQuery();
                                        ?>
                                        <select onchange="tp()" required class="form-control select" id="user_id" name="user_id">
                                            <option value="" <?= ($user_id == "") ? "selected" : ""; ?>>Pilih User</option>
                                            <?php
                                            foreach ($user->getResult() as $user) { ?>
                                                <option departemen_id="<?= $user->departemen_id; ?>" departemen_name="<?= $user->departemen_name; ?>" user_name="<?= $user->user_nama; ?>" user_payrolltype="<?= $user->user_payrolltype; ?>" user_lembur="<?= $user->user_lembur; ?>" value="<?= $user->user_id; ?>" <?= ($user_id == $user->user_id) ? "selected" : ""; ?>><?= $user->user_name; ?> - <?= $user->user_nama; ?> (<?= $user->user_nik; ?>)</option>
                                            <?php } ?>
                                        </select>
                                        <input type="hidden" id="departemen_id" name="departemen_id" value="<?= $departemen_id; ?>" />
                                        <input type="hidden" id="departemen_name" name="departemen_name" value="<?= $departemen_name; ?>" />
                                        <input type="hidden" id="user_payrolltype" name="user_payrolltype" value="<?= $user_payrolltype; ?>" />
                                        <input type="hidden" id="user_lembur" name="user_lembur" value="<?= $user_lembur; ?>" />
                                        <input type="hidden" id="user_name" name="user_name" value="<?= $user_name; ?>" />
                                        <script>
                                            function tp() {


                                                let departemen_id = $("#user_id").find(':selected').attr('departemen_id');
                                                $("#departemen_id").val(departemen_id);


                                                let departemen_name = $("#user_id").find(':selected').attr('departemen_name');
                                                $("#departemen_name").val(departemen_name);


                                                let user_payrolltype = $("#user_id").find(':selected').attr('user_payrolltype');
                                                $("#user_payrolltype").val(user_payrolltype);


                                                let user_lembur = $("#user_id").find(':selected').attr('user_lembur');
                                                $("#user_lembur").val(user_lembur);


                                                let user_name = $("#user_id").find(':selected').attr('user_name');
                                                $("#user_name").val(user_name);
                                            }
                                        </script>
                                    </div>
                                </div>

                                <input type="hidden" name="absen_id" value="<?= $absen_id; ?>" />
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                        <a class="btn btn-warning col-md-offset-1 col-md-5" href="<?= base_url("absen"); ?>">Back</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php } else { ?>
                        <?php if ($message != "") { ?>
                            <div class="alert alert-info alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong><?= $message; ?></strong>
                            </div>
                        <?php } ?>
                        <div class="alert alert-dark">
                            <form>
                                <div class="row">
                                    <?php
                                    $dari = date("Y-m-d");
                                    $ke = date("Y-m-d");
                                    $idepartemen = 0;
                                    if (isset($_GET["dari"])) {
                                        $dari = $_GET["dari"];
                                    }
                                    if (isset($_GET["ke"])) {
                                        $ke = $_GET["ke"];
                                    }
                                    if (isset($_GET["departemen"])) {
                                        $idepartemen = $_GET["departemen"];
                                    }
                                    ?>
                                    <div class="col-4 row mb-2">
                                        <div class="col-5">
                                            <label class="text-dark">Departemen : </label>
                                        </div>
                                        <div class="col-7">
                                            <select class="form-control" id="Departemen" name="departemen">
                                                <?php
                                                $departemen = $this->db->table("departemen")->orderBy("departemen_name")->get(); ?>
                                                <option value="">Pilih Departemen</option>
                                                <?php foreach ($departemen->getResult() as $departemen) { ?>
                                                    <option value="<?= $departemen->departemen_id; ?>" <?= ($idepartemen == $departemen->departemen_id) ? "selected" : ""; ?>><?= $departemen->departemen_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-8 row mb-2">
                                        <div class="col-3">

                                        </div>
                                        <div class="col-9">

                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark">Dari :</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="date" class="form-control" placeholder="Dari" name="dari" value="<?= $dari; ?>">
                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark">Ke :</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="date" class="form-control" placeholder="Ke" name="ke" value="<?= $ke; ?>">
                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark"></label>
                                        </div>
                                        <div class="col-9">
                                            <button type="submit" class="btn btn-block btn-primary">Cari</button>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <!-- <table id="dataTable" class="table table-condensed table-hover w-auto dtable"> -->
                                <thead class="">
                                    <tr>
                                        <?php if (!isset($_GET["report"])) { ?>
                                            <th>Action</th>
                                        <?php } ?>
                                        <!-- <th>No.</th> -->
                                        <!-- <th>Picture</th> -->
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Type</th>
                                        <th>Note</th>
                                        <th>Dept.</th>
                                        <th>Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $build = $this->db
                                        ->table("absen")
                                        ->where("absen_date >=", $dari)
                                        ->where("absen_date <=", $ke);
                                    if ($idepartemen > 0) {
                                        $build->where("departemen_id", $idepartemen);
                                    }
                                    $usr = $build->orderBy("absen_date", "ASC")
                                        ->orderBy("absen_time", "ASC")
                                        ->orderBy("user_name", "ASC")
                                        ->orderBy("absen_geo", "ASC")
                                        ->get();
                                    // echo $this->db->getLastquery();
                                    $no = 1;
                                    foreach ($usr->getResult() as $usr) { ?>
                                        <tr>
                                            <?php if (!isset($_GET["report"])) { ?>
                                                <td style="padding-left:0px; padding-right:0px;">
                                                    <?php
                                                    if (
                                                        (
                                                            isset(session()->get("position_administrator")[0][0])
                                                            && (
                                                                session()->get("position_administrator") == "1"
                                                                || session()->get("position_administrator") == "2"
                                                            )
                                                        ) ||
                                                        (
                                                            isset(session()->get("halaman")['50']['act_update'])
                                                            && session()->get("halaman")['50']['act_update'] == "1"
                                                        )
                                                    ) { ?>
                                                        <form method="post" class="btn-action" style="">
                                                            <button class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                            <input type="hidden" name="absen_id" value="<?= $usr->absen_id; ?>" />
                                                        </form>
                                                    <?php } ?>

                                                    <?php
                                                    if (
                                                        (
                                                            isset(session()->get("position_administrator")[0][0])
                                                            && (
                                                                session()->get("position_administrator") == "1"
                                                                || session()->get("position_administrator") == "2"
                                                            )
                                                        ) ||
                                                        (
                                                            isset(session()->get("halaman")['50']['act_delete'])
                                                            && session()->get("halaman")['50']['act_delete'] == "1"
                                                        )
                                                    ) { ?>
                                                        <form method="post" class="btn-action" style="">
                                                            <button class="btn btn-sm btn-danger delete" onclick="return confirm(' you want to delete?');" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                            <input type="hidden" name="absen_id" value="<?= $usr->absen_id; ?>" />
                                                        </form>
                                                    <?php } ?>
                                                </td>
                                            <?php } ?>
                                            <!-- <td><?= $no++; ?></td> -->
                                            <!-- <td><i class="fa fa-camera tunjuk" onclick="tampilgambar('<?= $usr->absen_id; ?>');"></i></td> -->
                                            <td><?= $usr->absen_date; ?></td>
                                            <td><?= $usr->absen_time; ?></td>
                                            <td><?= $usr->absen_type; ?></td>
                                            <td><?= $usr->absen_note; ?></td>
                                            <td><?= $usr->departemen_name; ?></td>
                                            <td><?= $usr->user_name; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <script>
                                function tampilgambar(id) {
                                    $.get("<?= base_url("api/gambarabsen"); ?>", {
                                            id: id
                                        })
                                        .done(function(data) {
                                            if (data != "") {
                                                $("#gambarabsen").hide();
                                                $("#exampleModal").modal("show");
                                                $("#gambarabsen").attr("src", data);
                                                $("#gambarabsen").fadeIn();
                                            } else {
                                                toast("Loading Gambar", "Maaf, tidak ada gambar!");
                                            }
                                        });
                                }
                            </script>
                            <!-- Picture -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <img id="gambarabsen" src="<?= base_url("images/picture.png"); ?>" class="gambar" style="width:100%; height:auto;" />
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('.select').select2();
        var title = "Absensi";
        $("title").text(title);
        $(".card-title").text(title);
        $("#page-title").text(title);
        $("#page-title-link").text(title);
    </script>

    <?php echo  $this->include("template/footer_v"); ?>