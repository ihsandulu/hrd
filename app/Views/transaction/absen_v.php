<?php echo $this->include("template/header_v"); ?>
<style>
    #modal-content {
        background-color: transparent;
        /* Membuat latar belakang modal menjadi transparan */
        border: none;
    }

    #modal-body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 80vh;
        /* Mengatur tinggi modal menjadi 80% tinggi layar */
    }

    #modal-body .gambar {
        max-height: 100%;
        /* Membuat gambar tidak melebihi tinggi modal */
        width: auto;
        height: auto;
    }

    #preloader {
        position: relative;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        /* width: 100%;
        height: 100%; */
        background-color: transparent;
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .loader {
        width: 40px;
        height: 40px;
        border: 4px solid #007bff;
        border-top: 4px solid transparent;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
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
                                        if (absen_type == "Masuk") {
                                            $(".cmasuk").show();
                                        } else {
                                            $(".cmasuk").hide();
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
                                        if (absen_type == "Masuk") {
                                            $(".cmasuk").show();
                                        } else {
                                            $(".cmasuk").hide();
                                            $(".imasuk").prop("value", "");
                                        }
                                    }
                                    $(document).ready(function() {
                                        $(".sakit").hide();
                                        $(".cuti").hide();
                                        $(".cmasuk").hide();
                                        pilihtipeori();
                                    });
                                </script>


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
                                                <option departemen_id="<?= $user->departemen_id; ?>" departemen_name="<?= $user->departemen_name; ?>" user_etag="<?= $user->user_etag; ?>" user_name="<?= $user->user_nama; ?>" user_payrolltype="<?= $user->user_payrolltype; ?>" user_lembur="<?= $user->user_lembur; ?>" value="<?= $user->user_id; ?>" <?= ($user_id == $user->user_id) ? "selected" : ""; ?>><?= $user->user_nama; ?> - <?= $user->departemen_name; ?> (<?= $user->user_nik; ?>)</option>
                                            <?php } ?>
                                        </select>
                                        <input type="hidden" id="departemen_id" name="departemen_id" value="<?= $departemen_id; ?>" />
                                        <input type="hidden" id="departemen_name" name="departemen_name" value="<?= $departemen_name; ?>" />
                                        <input type="hidden" id="user_payrolltype" name="user_payrolltype" value="<?= $user_payrolltype; ?>" />
                                        <input type="hidden" id="user_lembur" name="user_lembur" value="<?= $user_lembur; ?>" />
                                        <input type="hidden" id="user_name" name="user_name" value="<?= $user_name; ?>" />
                                        <input type="hidden" id="user_etag" name="user_etag" value="<?= $user_etag; ?>" />
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

                                                let user_etag = $("#user_id").find(':selected').attr('user_etag');
                                                $("#user_etag").val(user_etag);
                                            }
                                        </script>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="absen_date">Date:</label>
                                    <div class="col-sm-10">
                                        <input required type="date" class="form-control" id="absen_date" name="absen_date" placeholder="" value="<?= $absen_date; ?>">
                                    </div>
                                </div>

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
                                            <?php $cuti = $this->db->table("cuti")->orderBy("cuti_name", "ASC")->get(); ?>
                                            <?php foreach ($cuti->getResult() as $cuti) { ?>
                                                <option value="<?= $cuti->cuti_id; ?>" <?= ($cuti_id == $cuti->cuti_id) ? "selected" : ""; ?>><?= $cuti->cuti_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group cmasuk">
                                    <label class="control-label col-sm-2" for="absen_masuk">Masuk:</label>
                                    <div class="col-sm-10">
                                        <input type="datetime-local" class="form-control imasuk" id="absen_masuk" name="absen_masuk" placeholder="" value="<?= $absen_masuk; ?>">
                                    </div>
                                </div>



                                <div class="form-group cmasuk">
                                    <label class="control-label col-sm-2" for="absen_keluar">Keluar:</label>
                                    <div class="col-sm-10">
                                        <input type="datetime-local" class="form-control imasuk" id="absen_keluar" name="absen_keluar" placeholder="" value="<?= $absen_keluar; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="absen_note">Keterangan:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="absen_note" name="absen_note" placeholder="" value="<?= $absen_note; ?>">
                                    </div>
                                </div>










                                <!-- <div class="form-group">
                                    <label class="control-label col-sm-2" for="absen_geo">Geolocation:</label>
                                    <div class="col-sm-10">
                                        <input required type="text"  class="form-control" id="absen_geo" name="absen_geo" placeholder="" value="<?= $absen_geo; ?>">
                                    </div>
                                </div> -->

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
                                        <div class="col-3">
                                            <label class="text-dark">Dept. : </label>
                                        </div>
                                        <div class="col-9">
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
                                        <th>Type</th>
                                        <th>Dept.</th>
                                        <th>Name</th>
                                        <th>Note</th>
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
                                        ->orderBy("user_name", "ASC")
                                        ->orderBy("absen_geo", "ASC")
                                        ->get();
                                    // echo $this->db->getLastquery();
                                    $no = 1;
                                    foreach ($usr->getResult() as $usr) {
                                        if ($usr->absen_type == "Masuk") {
                                            $absen_masuk = "<span class=\"text-primary\">Masuk:</span> " . $usr->absen_masuk;
                                            $absen_keluar = $usr->absen_keluar;
                                            if ($absen_keluar != "") {
                                                $absen_keluar = "<br/><span class=\"text-danger\">Keluar:</span> " . $usr->absen_keluar;
                                            } else {
                                                $absen_keluar = "";
                                            }
                                            $absen_lemburjam = $usr->absen_lemburjam;
                                            if ($absen_lemburjam != "") {
                                                $absen_lemburjam = "<br/><span class=\"text-danger\">Lembur:</span> " . $usr->absen_lemburjam . " Jam";
                                            } else {
                                                $absen_lemburjam = "";
                                            }
                                            $usr->absen_note = $absen_masuk . $absen_keluar . $absen_lemburjam;
                                        }
                                        if ($usr->absen_type == "Sakit") {
                                            if ($usr->absen_skd == 1) {
                                                $skd = "SKD : Ya. ";
                                            } else {
                                                $skd = "SKD : Tidak. ";
                                            }
                                            $usr->absen_note = $skd . "Ket: " . $usr->absen_note;
                                        }
                                        if ($usr->absen_type == "Cuti") {
                                            $cuti = $this->db->table("cuti")->where("cuti_id", $usr->cuti_id)->get();
                                            $gugur = "";
                                            foreach ($cuti->getResult() as $cuti) {
                                                $gugur = $cuti->cuti_name . ". ";
                                            }
                                            $usr->absen_note = $gugur . "Ket: " . $usr->absen_note;
                                        }
                                    ?>
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
                                            <td><?= $usr->absen_type; ?></td>
                                            <td><?= $usr->departemen_name; ?></td>
                                            <td><?= $usr->user_name; ?></td>
                                            <td>
                                                <?= $usr->absen_note; ?>
                                                <?php if ($usr->absen_pulangcepat > 0 && $usr->absen_type == "Masuk") {
                                                    echo "<br/>(Pulang Cepat: <span class=\"text-danger\">" . $usr->absen_pulangcepatmenit . " Menit</span>)";
                                                } ?>
                                            </td>
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
                                    <div class="modal-content" id="modal-content">
                                        <div class="modal-body" id="modal-body">
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