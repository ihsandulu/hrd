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

                        <!-- <?php if (!isset($_POST['new']) && !isset($_POST['edit']) && !isset($_GET['report'])) { ?>
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
                                        <input type="hidden" name="gaji_id" />
                                    </h1>
                                </form>
                            <?php } ?>
                        <?php } ?> -->
                    </div>

                    <?php if (isset($_POST['new']) || isset($_POST['edit'])) { ?>
                        <div class="">
                            <?php if (isset($_POST['edit'])) {
                                $namabutton = 'name="change"';
                                $judul = "Update Penggajian";
                            } else {
                                $namabutton = 'name="create"';
                                $judul = "Tambah Penggajian";
                            } ?>
                            <div class="lead">
                                <h3><?= $judul; ?></h3>
                            </div>
                            <form class="form-horizontal" method="post" enctype="multipart/form-data">


                                <input type="hidden" name="gaji_id" value="<?= $gaji_id; ?>" />
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                        <a class="btn btn-warning col-md-offset-1 col-md-5" href="<?= base_url("gaji"); ?>">Back</a>
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
                                    $gaji_bulan = date("Y-m-d");
                                    $gaji_tahun = date("Y-m-d");
                                    $departemen_id = 0;
                                    $position_id = 0;
                                    $user_id = 0;
                                    $gaji_print = date("Y-m-05");
                                    if (isset($_GET["gaji_bulan"])) {
                                        $gaji_bulan = $_GET["gaji_bulan"];
                                    }
                                    if (isset($_GET["gaji_tahun"])) {
                                        $gaji_tahun = $_GET["gaji_tahun"];
                                    }
                                    if (isset($_GET["departemen_id"])) {
                                        $departemen_id = $_GET["departemen_id"];
                                    }
                                    if (isset($_GET["position_id"])) {
                                        $position_id = $_GET["position_id"];
                                    }
                                    if (isset($_GET["user_id"])) {
                                        $user_id = $_GET["user_id"];
                                    }
                                    if (isset($_GET["gaji_print"])&&$_GET["gaji_print"]!="") {
                                        $gaji_print = $_GET["gaji_print"];
                                    }
                                    // echo $gaji_print;
                                    ?>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark">Dep. : </label>
                                        </div>
                                        <div class="col-9">
                                            <select class="form-control" id="departemen_id" name="departemen_id">
                                                <?php
                                                $departemen = $this->db->table("departemen")->orderBy("departemen_name")->get(); ?>
                                                <option value="">Semua Departemen</option>
                                                <?php foreach ($departemen->getResult() as $departemen) { ?>
                                                    <option value="<?= $departemen->departemen_id; ?>" <?= ($departemen_id == $departemen->departemen_id) ? "selected" : ""; ?>><?= $departemen->departemen_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark">Posisi : </label>
                                        </div>
                                        <div class="col-9">
                                            <select class="form-control" id="position_id" name="position_id">
                                                <?php
                                                $position = $this->db->table("position")->orderBy("position_name")->get(); ?>
                                                <option value="">Semua Posisi</option>
                                                <?php foreach ($position->getResult() as $position) { ?>
                                                    <option value="<?= $position->position_id; ?>" <?= ($position_id == $position->position_id) ? "selected" : ""; ?>><?= $position->position_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark">User : </label>
                                        </div>
                                        <div class="col-9">
                                            <select class="form-control" id="user_id" name="user_id">
                                                <?php
                                                $user = $this->db->table("user")->orderBy("user_name")->get(); ?>
                                                <option value="">Semua User</option>
                                                <?php foreach ($user->getResult() as $user) { ?>
                                                    <option value="<?= $user->user_id; ?>" <?= ($user_id == $user->user_id) ? "selected" : ""; ?>><?= $user->user_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark">Bulan :</label>
                                        </div>
                                        <div class="col-9">
                                            <select class="form-control" name="gaji_bulan">
                                                <option value="" <?= ($gaji_bulan == "") ? "selected" : ""; ?>>Pilih Bulan</option>
                                                <?php
                                                $bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                                                foreach ($bulan as $key => $value) { ?>
                                                    <option value="<?= str_pad($key + 1, 2, "0", STR_PAD_LEFT); ?>" <?= ($gaji_bulan == str_pad($key + 1, 2, "0", STR_PAD_LEFT)) ? "selected" : ""; ?>><?= $value; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark">Tahun :</label>
                                        </div>
                                        <div class="col-9">
                                            <select class="form-control" name="gaji_tahun">
                                                <option value="">Pilih Tahun</option>
                                                <?php
                                                for ($tahun = 2020; $tahun <= 2050; $tahun++) { ?>
                                                    <option value="<?= $tahun; ?>" <?= ($tahun == date("Y")) ? "selected" : ""; ?>><?= $tahun; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark">Print Date :</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="date" class="form-control" placeholder="Print Date" name="gaji_print" value="<?= $gaji_print; ?>">
                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-4">
                                            <label class="text-dark">Priode :</label>
                                        </div>
                                        <?php 
                                        if(isset($_GET["dari"])){
                                            $dari = $_GET["dari"];
                                        }else{
                                            $dari = date("Y-m-01");
                                        }
                                        if(isset($_GET["ke"])){
                                            $ke = $_GET["ke"];
                                        }else{
                                            $ke = date("Y-m-t");
                                        }
                                        ?>
                                        <div class="col-4">
                                            <input type="date" class="form-control" placeholder="Dari" name="dari" value="<?= $dari; ?>">
                                        </div>
                                        <div class="col-4">
                                            <input type="date" class="form-control" placeholder="Ke" name="ke" value="<?= $ke; ?>">
                                        </div>
                                    </div>
                                    <div class="col-12 row">
                                        <div class="col-12">
                                            <button name="generate" value="OK" type="submit" class="btn btn-block btn-primary" onclick="return confirmGenerate()">Generate</button>
                                        </div>
                                        <script>
                                            function confirmGenerate() {
                                                return confirm("Apakah Anda yakin ingin melanjutkan?");
                                            }
                                        </script>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="alert alert-dark">
                            <form>
                                <div class="row">
                                    <?php
                                    $gaji_bulan = date("Y-m-d");
                                    $gaji_tahun = date("Y-m-d");
                                    $departemen_id = 0;
                                    $position_id = 0;
                                    $user_id = 0;
                                    if (isset($_GET["gaji_bulan"])) {
                                        $gaji_bulan = $_GET["gaji_bulan"];
                                    }
                                    if (isset($_GET["gaji_tahun"])) {
                                        $gaji_tahun = $_GET["gaji_tahun"];
                                    }
                                    if (isset($_GET["departemen_id"])) {
                                        $departemen_id = $_GET["departemen_id"];
                                    }
                                    if (isset($_GET["position_id"])) {
                                        $position_id = $_GET["position_id"];
                                    }
                                    if (isset($_GET["user_id"])) {
                                        $user_id = $_GET["user_id"];
                                    }
                                    ?>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark">Dep. : </label>
                                        </div>
                                        <div class="col-9">
                                            <select class="form-control" id="departemen_id" name="departemen_id">
                                                <?php
                                                $departemen = $this->db->table("departemen")->orderBy("departemen_name")->get(); ?>
                                                <option value="">Semua Departemen</option>
                                                <?php foreach ($departemen->getResult() as $departemen) { ?>
                                                    <option value="<?= $departemen->departemen_id; ?>" <?= ($departemen_id == $departemen->departemen_id) ? "selected" : ""; ?>><?= $departemen->departemen_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark">Posisi : </label>
                                        </div>
                                        <div class="col-9">
                                            <select class="form-control" id="position_id" name="position_id">
                                                <?php
                                                $position = $this->db->table("position")->orderBy("position_name")->get(); ?>
                                                <option value="">Semua Posisi</option>
                                                <?php foreach ($position->getResult() as $position) { ?>
                                                    <option value="<?= $position->position_id; ?>" <?= ($position_id == $position->position_id) ? "selected" : ""; ?>><?= $position->position_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark">User : </label>
                                        </div>
                                        <div class="col-9">
                                            <select class="form-control" id="user_id" name="user_id">
                                                <?php
                                                $user = $this->db->table("user")->orderBy("user_name")->get(); ?>
                                                <option value="">Semua User</option>
                                                <?php foreach ($user->getResult() as $user) { ?>
                                                    <option value="<?= $user->user_id; ?>" <?= ($user_id == $user->user_id) ? "selected" : ""; ?>><?= $user->user_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark">Bulan :</label>
                                        </div>
                                        <div class="col-9">
                                            <select class="form-control" name="gaji_bulan">
                                                <option value="" <?= ($gaji_bulan == "") ? "selected" : ""; ?>>Pilih Bulan</option>
                                                <?php
                                                $bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                                                foreach ($bulan as $key => $value) { ?>
                                                    <option value="<?= str_pad($key + 1, 2, "0", STR_PAD_LEFT); ?>" <?= ($gaji_bulan == str_pad($key + 1, 2, "0", STR_PAD_LEFT)) ? "selected" : ""; ?>><?= $value; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark">Tahun :</label>
                                        </div>
                                        <div class="col-9">
                                            <select class="form-control" name="gaji_tahun">
                                                <option value="">Pilih Tahun</option>
                                                <?php
                                                for ($tahun = 2020; $tahun <= 2050; $tahun++) { ?>
                                                    <option value="<?= $tahun; ?>" <?= ($tahun == date("Y")) ? "selected" : ""; ?>><?= $tahun; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark"></label>
                                        </div>
                                        <div class="col-9">
                                            <button type="submit" class="btn btn-block btn-info">Cari</button>
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
                                        <th>Print Date</th>
                                        <th>Departemen</th>
                                        <th>Posisi</th>
                                        <th>Nama</th>
                                        <th>Absensi</th>
                                        <th>Gapok</th>
                                        <th>T.Jabatan</th>
                                        <th>T.Transport</th>
                                        <th>T.gaji_tahunhadiran</th>
                                        <th>T.Makan</th>
                                        <th>OT1</th>
                                        <th>OT2</th>
                                        <th>OT3</th>
                                        <th>OT4</th>
                                        <th>Gaji Kotor</th>
                                        <th>P.Absen</th>
                                        <th>P.Inventaris</th>
                                        <th>BPJS gaji_tahuns</th>
                                        <th>BPJS JHT</th>
                                        <th>BPJS Pensiun</th>
                                        <th>PPH21</th>
                                        <th>P.Lain</th>
                                        <th>P.Total</th>
                                        <th>Gaji total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $build = $this->db
                                        ->table("gaji")
                                        ->where("gaji_print >=", $gaji_bulan)
                                        ->where("gaji_print <=", $gaji_tahun);
                                    if ($departemen_id > 0) {
                                        $build->where("departemen_id", $departemen_id);
                                    }
                                    $usr = $build->orderBy("gaji_print", "ASC")
                                        ->orderBy("position_name", "ASC")
                                        ->orderBy("user_name", "ASC")
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
                                                            <input type="hidden" name="gaji_id" value="<?= $usr->gaji_id; ?>" />
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
                                                            <input type="hidden" name="gaji_id" value="<?= $usr->gaji_id; ?>" />
                                                        </form>
                                                    <?php } ?>
                                                </td>
                                            <?php } ?>
                                            <!-- <td><?= $no++; ?></td> -->
                                            <!-- <td><i class="fa fa-camera tunjuk" onclick="tampilgambar('<?= $usr->gaji_id; ?>');"></i></td> -->
                                            <td><?= $usr->gaji_print; ?></td>
                                            <td><?= $usr->departemen_name; ?></td>
                                            <td><?= $usr->position_name; ?></td>
                                            <td><?= $usr->user_name; ?></td>
                                            <td><?= $usr->gaji_pokok; ?></td>
                                            <td><?= $usr->user_name; ?> (<?= $usr->user_nik; ?>)</td>

                                            <td><?= $usr->gaji_print; ?></td>
                                            <td><?= $usr->departemen_name; ?></td>
                                            <td><?= $usr->position_name; ?></td>
                                            <td><?= $usr->user_name; ?></td>
                                            <td>H:<?= $usr->gaji_hadir; ?>|C:<?= $usr->gaji_cuti; ?>|S:<?= $usr->gaji_sakit; ?>|I:<?= $usr->gaji_izin; ?>|A: <?= $usr->gaji_alpha; ?></td>
                                            <td><?= $usr->gaji_pokok; ?></td>
                                            <td><?= $usr->gaji_tjabatan; ?></td>
                                            <td><?= $usr->gaji_ttransport; ?></td>
                                            <td><?= $usr->gaji_tgaji_tahunhadiran; ?></td>
                                            <td><?= $usr->gaji_tmakan; ?></td>
                                            <td><?= $usr->gaji_lembur1; ?></td>
                                            <td><?= $usr->gaji_lembur2; ?></td>
                                            <td><?= $usr->gaji_lembur3; ?></td>
                                            <td><?= $usr->gaji_lembur4; ?></td>
                                            <td><?= $usr->gaji_kotor; ?></td>
                                            <td><?= $usr->gaji_pabsen; ?></td>
                                            <td><?= $usr->gaji_inventaris; ?></td>
                                            <td><?= $usr->gaji_bpjsgaji_tahunsehatan; ?></td>
                                            <td><?= $usr->gaji_bpjsjht; ?></td>
                                            <td><?= $usr->gaji_bpjspensiun; ?></td>
                                            <td><?= $usr->gaji_pph21; ?></td>
                                            <td><?= $usr->gaji_plain; ?></td>
                                            <td><?= $usr->gaji_potongantotal; ?></td>
                                            <td><?= $usr->gaji_total; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <script>
                                function tampilgambar(id) {
                                    $.get("<?= base_url("api/gambargaji"); ?>", {
                                            id: id
                                        })
                                        .done(function(data) {
                                            if (data != "") {
                                                $("#gambargaji").hide();
                                                $("#exampleModal").modal("show");
                                                $("#gambargaji").attr("src", data);
                                                $("#gambargaji").fadeIn();
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
                                            <img id="gambargaji" src="<?= base_url("images/picture.png"); ?>" class="gambar" style="width:100%; height:auto;" />
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
        var title = "Penggajian";
        $("title").text(title);
        $(".card-title").text(title);
        $("#page-title").text(title);
        $("#page-title-link").text(title);
    </script>

    <?php echo  $this->include("template/footer_v"); ?>